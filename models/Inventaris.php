<?php

namespace app\models;

use app\models\base\Inventaris as BaseInventaris;
use mdm\autonumber\AutoNumber;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inventaris".
 */
class Inventaris extends BaseInventaris
{
   public ?string $lastOrder = null;
   public ?string $lastRepaired = null;
   public ?string $lastRemarks = null;
   public ?string $lastLocation = null;
   public ?string $merk = null;
   public ?string $description = null;
   public ?string $namaSatuan = null;
   public ?string $kondisi = null;


   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            [['lastOrder', 'lastRepaired', 'lastRemarks', 'lastLocation', 'merk', 'description', 'namaSatuan', 'kondisi'], 'safe']
         ]
      );
   }

   /**
    * Sebelum save, generate kode inventaris
    * @param $insert
    * @return bool
    */
   public function beforeSave($insert): bool
   {
      if ($insert) {

         # Cari material requisition detail penawaran berdasarkan id nya
         $mrdp = MaterialRequisitionDetailPenawaran::findOne([
            'id' => $this->material_requisition_detail_penawaran_id
         ]);

         // Get ift_number nya
         $barangIftNumber = $mrdp
            ->materialRequisitionDetail
            ->barang
            ->ift_number;

         // Assign kode inventaris tersebut
         $this->kode_inventaris = AutoNumber::generate(
            ($barangIftNumber . '/' . 'INV-' . '?'),
            true,
            4
         );
      }

      return parent::beforeSave($insert);
   }

   public function attributeLabels()
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'namaSatuan' => 'Unit',
         'quantity' => 'Qty',
      ]);
   }
}