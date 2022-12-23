<?php

namespace app\models;

use app\enums\TandaTerimaStatusEnum;
use app\models\base\MaterialRequisitionDetailPenawaran as BaseMaterialRequisitionDetailPenawaran;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "material_requisition_detail_penawaran".
 * @property $statusPenerimaan bool
 * @property $totalQuantitySudahDiTerima float | int
 */
class MaterialRequisitionDetailPenawaran extends BaseMaterialRequisitionDetailPenawaran
{

   public float|int|null $totalQuantitySudahDiterima = null;

   public ?string $asOptionList = null;
   public ?string $namaBarang = null;
   public ?string $namaSatuan = null;
   public ?string $namaVendor = null;
   public ?string $nomorPurchaseOrder = null;
   public ?string $quantityInventaris = null;
   public ?string $quantityMrdpBelumMasukDiInventaris = null;

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            [['namaBarang', 'namaSatuan', 'nomorPurchaseOrder', 'quantityInventaris'], 'safe']
         ]
      );
   }

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'material_requisition_detail_id' => 'Material Requisition Detail',
         'vendor_id' => 'Vendor',
         'purchase_order_id' => 'Purchase Order',
         'mata_uang_id' => 'Mata Uang',
         'quantity_pesan' => 'Qty Pesan',
      ]);
   }

   public function getStatusLabel(): string
   {
      $htmlElement = Json::decode($this->status->options);
      return Html::tag(
         $htmlElement['tag'],
         $this->status->key,
         $htmlElement['options']
      );
   }

   public function getSubtotal(): float|int
   {
      return $this->quantity_pesan * $this->harga_penawaran;
   }

   /**
    * @return string
    */
   public function getStatusPenerimaanInHtmlLabel($tag = 'span'): string
   {
      return $this->getStatusPenerimaan()
         ? Html::tag($tag,
            "<i class='bi bi-check-circle-fill'></i> " . TandaTerimaStatusEnum::COMPLETED->value, [
               'class' => 'badge bg-primary'
            ])
         : Html::tag($tag,
            "<i class='bi bi-x-circle-fill'></i> " . TandaTerimaStatusEnum::NOT_COMPLETED->value, [
               'class' => 'badge bg-danger'
            ]);
   }

   public function getStatusPenerimaan(): bool
   {
      return $this->quantity_pesan == $this->getTotalQuantitySudahDiTerima();
   }

   public function getTotalQuantitySudahDiTerima(): float|int
   {
      return array_sum(array_column(ArrayHelper::toArray($this->tandaTerimaBarangDetails), 'quantity_terima'));
   }

   /**
    * @return ActiveQuery
    */
   public function getTandaTerimaBarang(): ActiveQuery
   {
      return $this->hasOne(TandaTerimaBarang::class, ['tanda_terima_barang_id' => 'id'])
         ->via('tandaTerimaBarangDetails');
   }

}