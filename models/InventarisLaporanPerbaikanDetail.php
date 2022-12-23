<?php

namespace app\models;

use app\models\base\InventarisLaporanPerbaikanDetail as BaseInventarisLaporanPerbaikanDetail;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inventaris_laporan_perbaikan_detail".
 */
class InventarisLaporanPerbaikanDetail extends BaseInventarisLaporanPerbaikanDetail
{

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
         ]
      );
   }

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'id' => 'ID',
         'inventaris_laporan_perbaikan_master_id' => 'Inventaris Laporan Perbaikan Master',
         'inventaris_id' => 'Inventaris',
         'kondisi_id' => 'Kondisi',
         'last_location_id' => 'Last Location',
         'last_repaired' => 'Last Repaired',
         'remarks' => 'Remarks',
         'estimated_price' => 'Estimated Price',
      ]);
   }

   public function beforeSave($insert): bool
   {

      $this->last_repaired = Yii::$app->formatter->asDatetime($this->last_repaired, "php:Y-m-d H:i");
      return parent::beforeSave($insert);
   }

   public function afterFind()
   {
      parent::afterFind();
      $this->last_repaired = Yii::$app->formatter->asDatetime($this->last_repaired);
   }

}