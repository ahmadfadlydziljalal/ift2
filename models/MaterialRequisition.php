<?php

namespace app\models;

use app\enums\TextLinkEnum;
use app\models\base\MaterialRequisition as BaseMaterialRequisition;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "material_requisition".
 * @property string $purchaseOrdersNomorAsHtml
 * @see self::getPurchaseOrdersNomorAsHtml()
 *
 * @property PurchaseOrder[] $purchaseOrders
 * @property array $purchaseOrdersNomor
 */
class MaterialRequisition extends BaseMaterialRequisition
{

   use NomorSuratTrait;

   /**
    * @var $modelsDetail MaterialRequisitionDetail[]
    * */
   public array $modelsDetail;

   /**
    * @return array
    */
   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/MR/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   /**
    * @return array
    */
   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
         ]
      );
   }

   /**
    * @return array
    */
   public function getMaterialRequisitionDetailsGroupingByTipePembelian(): array
   {
      $parentMaterialRequisitionDetails = parent::getMaterialRequisitionDetails()
         ->select('material_requisition_detail.*')
         ->addSelect([
            'tipePembelianNama' => 'tipe_pembelian.nama',
            'barangId' => 'barang.part_number',
            'barangPartNumber' => 'barang.part_number',
            'barangIftNumber' => 'barang.ift_number',
            'barangMerkPartNumber' => 'barang.merk_part_number',
            'barangNama' => 'barang.nama',
            'satuanNama' => 'satuan.nama',
            'vendorNama' => 'card.nama',
            'penawaranDariVendor' => new Expression(
               'JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    "vendor", vendorPenawar.nama
                                    , "harga_penawaran", FORMAT(harga_penawaran, 2)
                                    , "status", status.key
                                    , "status_options", status.options
                                    , "purchase_order_id", purchase_order.nomor
                                    
                                )
                              )'
            )
         ])
         ->joinWith(['barang' => function ($barang) {
            $barang->joinWith('tipePembelian', false);
         }], false)
         ->joinWith('satuan', false)
         ->joinWith('vendor', false)
         ->joinWith(['materialRequisitionDetailPenawarans' => function ($mrdp) {
            $mrdp->alias('mrdp')
               ->joinWith('status', false)
               ->joinWith(['vendor' => function ($vendorPenawar) {
                  $vendorPenawar->alias('vendorPenawar');
               }], false)
               ->joinWith('purchaseOrder', false);
         }], false)
         ->groupBy('material_requisition_detail.id')
         ->all();

      return ArrayHelper::index(
         $parentMaterialRequisitionDetails,
         null,
         'tipePembelianNama'
      );

   }

   /**
    * @return ActiveQuery
    */
   public function getMaterialRequisitionDetails(): ActiveQuery
   {
      return parent::getMaterialRequisitionDetails()
         ->select('material_requisition_detail.*')
         ->addSelect('barang.tipe_pembelian_id as tipePembelian')
         ->joinWith('barang');
   }

   /**
    * @return ActiveQuery
    */
   public function getMaterialRequisitionDetailPenawarans(): ActiveQuery
   {
      return $this->hasMany(
         MaterialRequisitionDetailPenawaran::class,
         ['material_requisition_detail_id' => 'id']
      )->via('materialRequisitionDetails');
   }

   /**
    * @return ActiveQuery
    */
   public function getPurchaseOrders(): ActiveQuery
   {
      return $this->hasMany(
         PurchaseOrder::class,
         ['id' => 'purchase_order_id']
      )->via('materialRequisitionDetailPenawarans');
   }

   public function getPurchaseOrdersNomorAsHtml(): string
   {
      $data = $this->getPurchaseOrdersNomor();
      $string = '';
      foreach ($data as $key => $value) :
         $string .= Html::a($value, ['/purchase-order/view', 'id' => $key], [
            'class' => 'badge bg-info',
            'data' => [
               'bs-toggle' => 'modal',
               'bs-target' => '#ajax-modal'
            ]
         ]);
      endforeach;
      return $string;
   }

   public function getPurchaseOrdersNomor(): array
   {
      return $this->hasMany(
         PurchaseOrder::class,
         ['id' => 'purchase_order_id']
      )->via('materialRequisitionDetailPenawarans')
         ->indexBy('id')
         ->select('nomor')
         ->column();
   }

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         parent::attributeLabels(), [
            'vendor_id' => 'To (Orang Kantor) :',
            'approved_by_id' => 'Approved By',
            'acknowledge_by_id' => 'Acknowledge By',
         ]
      );
   }

   /**
    * @param array $modelsDetail
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function createWithDetails(array $modelsDetail): bool
   {
      $transaction = MaterialRequisition::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) {
            foreach ($modelsDetail as $detail) :
               $detail->material_requisition_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            Yii::$app->session->setFlash('success', [
               [
                  'title' => 'Sukses membuat sebuah Material Request',
                  'message' => 'Material Request: ' . $this->nomor . ' berhasil dibuat',
                  'footer' =>
                     Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-to-pdf', 'id' => $this->id], [
                        'target' => '_blank',
                        'class' => 'btn btn-success'
                     ])
               ]
            ]);

            return true;
         } else {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', " MaterialRequisition is failed to insert. Just rollback");
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   /**
    * @param array $modelsDetail
    * @param array $deletedDetailsID
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function updateWithDetails(array $modelsDetail, array $deletedDetailsID): bool
   {
      $transaction = MaterialRequisition::getDb()->beginTransaction();
      try {
         if ($flag = $this->save(false)) {

            if (!empty($deletedDetailsID)) {
               MaterialRequisitionDetail::deleteAll(['id' => $deletedDetailsID]);
            }

            foreach ($modelsDetail as $detail) :
               $detail->material_requisition_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            Yii::$app->session->setFlash('info', [
                  [
                     'title' => 'Update berhasil',
                     'message' => 'Material Requisition: ' . $this->nomor . ' berhasil di-update',
                     'footer' =>
                        Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print', 'id' => $this->id], [
                           'target' => '_blank',
                           'class' => 'btn btn-success'
                        ])
                  ]
               ]
            );
            return true;
         } else {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', " MaterialRequisition is failed to updated.");
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   public function getNext(): MaterialRequisition|array|null
   {
      return $this->find()->where(['>', 'id', $this->id])->one();
   }

   public function getPrevious(): MaterialRequisition|array|null
   {
      return $this->find()->where(['<', 'id', $this->id])->orderBy('id desc')->one();
   }

}