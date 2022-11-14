<?php

namespace app\models;

use app\components\helpers\SaveCacheKaryawan;
use app\enums\SVGIconEnum;
use app\models\base\PurchaseOrder as BasePurchaseOrder;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\httpclient\Exception;


/**
 * This is the model class for table "purchase_order".
 * @property $userKaryawan array
 * @property $usernameWhoCreated string
 * @property $nomorTandaTerimaColumns array
 * @property $nomorTandaTerimaColumnsAsHtml string
 * @property $statusTandaTerimaBarangs bool
 * @property $statusTandaTerimaBarangsAsHtml string
 * @property TandaTerimaBarangDetail[] $tandaTerimaBarangDetails
 * @property MaterialRequisition $materialRequisition
 * @property TandaTerimaBarang[] $tandaTerimaBarangs
 */
class PurchaseOrder extends BasePurchaseOrder implements MasterDetailsInterface
{

    use NomorSuratTrait;

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function createWithDetails(array $modelsDetail): array
    {

        $transaction = PurchaseOrder::getDb()->beginTransaction();

        try {

            if ($flag = $this->save(false)) {
                foreach ($modelsDetail as $detail) :
                    $detail->purchase_order_id = $this->id;
                    if (!($flag = $detail->save(false))) {
                        break;
                    }
                endforeach;
            }

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }

        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;

    }

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function updateWithDetails(array $modelsDetail, array $deletedDetailsID): array
    {
        $transaction = PurchaseOrder::getDb()->beginTransaction();
        try {
            if ($flag = $this->save(false)) {

                if (!empty($deletedDetailsID)) {
                    MaterialRequisitionDetail::updateAll(['purchase_order_id' => null], ['id' => $deletedDetailsID]);
                }

                foreach ($modelsDetail as $detail) :
                    $detail->purchase_order_id = $this->id;
                    if (!($flag = $detail->save(false))) {
                        break;
                    }
                endforeach;
            }

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }
        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [

                # custom behaviors,
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/PRC/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],

            ]
        );
    }

    public function rules(): array
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'vendor_id' => 'Vendor',
                'approved_by_id' => 'Approved By',
                'acknowledge_by_id' => 'Acknowledge By',
            ]
        );
    }

    public function getUsernameWhoCreated(): string
    {
        $user = User::findOne($this->created_by);
        return isset($user) ? $user->username : '';
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getUserKaryawan(): mixed
    {
        $cache = Yii::$app->cache;
        $dataKaryawan = $cache->get('sihrd-karyawan' . $this->created_by);

        if (empty($dataKaryawan)) {
            SaveCacheKaryawan::saveCache(User::findOne($this->created_by));
        }
        return $cache->get('sihrd-karyawan' . $this->created_by);
    }

    /**
     * @return ActiveQuery
     */
    public function getTandaTerimaBarangs(): ActiveQuery
    {
        return $this->hasMany(TandaTerimaBarang::class, ['id' => 'tanda_terima_barang_id'])
            ->via('tandaTerimaBarangDetails');
    }

    /**
     * Get nomor-nomor surat Tanda Terima Barang
     * @return array
     */
    public function getNomorTandaTerimaColumns(): array
    {
        return array_column(ArrayHelper::toArray($this->tandaTerimaBarangs), 'nomor');
    }

    /**
     * Get nomor-nomor surat Tanda Terima Barang sebagai string
     * @return string
     */
    public function getNomorTandaTerimaColumnsAsHtml(): string
    {
        $string = '';

        foreach ($this->nomorTandaTerimaColumns as $nomorTandaTerimaColumn):
            $string .= Html::tag('span', $nomorTandaTerimaColumn, ['class' => 'badge bg-info']) . '<br/>';
        endforeach;

        return $string;
    }

    /**
     * @return ActiveQuery
     */
    public function getTandaTerimaBarangDetails(): ActiveQuery
    {
        return $this->hasMany(TandaTerimaBarangDetail::class, ['material_requisition_detail_penawaran_id' => 'id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getVendor(): ActiveQuery
    {
        return $this->hasOne(Card::class, ['id' => 'vendor_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getMaterialRequisitionDetail(): ActiveQuery
    {
        return $this->hasOne(MaterialRequisitionDetail::class, ['id' => 'material_requisition_detail_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getMaterialRequisition(): ActiveQuery
    {
        return $this->hasOne(MaterialRequisition::class, ['id' => 'material_requisition_id'])
            ->via('materialRequisitionDetail');
    }

    public function getSumSubtotal(): float|int
    {
        return array_sum(
            array_map(function ($el) {
                return $el->quantity_pesan * $el->harga_penawaran;
            }, $this->materialRequisitionDetailPenawarans)
        );
    }

    /**
     * Status P.O dihitung dari:
     * material_requisition_detail_penawaran.quantity_pesan = total_quantity_yang_diterima
     * @return bool
     */
    public function getStatusTandaTerimaBarangs(): bool
    {
        $statusMaterialRequisition = [];
        foreach ($this->materialRequisitionDetailPenawarans as $materialRequisitionDetailPenawaran) {
            $statusMaterialRequisition[] = $materialRequisitionDetailPenawaran->getStatusPenerimaan();
        }

        return !in_array(false, $statusMaterialRequisition);

    }

    /**
     * Display status purchase order berdasarkan tanda terima dalam format HTML
     * @return string
     */
    public function getStatusTandaTerimaBarangsAsHtml(): string
    {
        return $this->statusTandaTerimaBarangs
            ?
            Html::tag('span', SVGIconEnum::CHECK->value . ' Completed', [
                'class' => 'badge bg-primary',
                'title' => $this->nomor
            ])
            :
            Html::tag('span', '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/> </svg>' .
                ' Not Completed',
                ['class' => 'badge bg-danger']
            );
    }


}