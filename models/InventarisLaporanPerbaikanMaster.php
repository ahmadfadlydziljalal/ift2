<?php

namespace app\models;

use app\models\base\InventarisLaporanPerbaikanMaster as BaseInventarisLaporanPerbaikanMaster;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inventaris_laporan_perbaikan_master".
 */
class InventarisLaporanPerbaikanMaster extends BaseInventarisLaporanPerbaikanMaster
{

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/LPBK/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules()
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
            'id' => 'ID',
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal',
            'card_id' => 'To',
            'status_id' => 'Status',
            'comment' => 'Comment',
            'approved_by_id' => 'Approved By',
            'known_by_id' => 'Known By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
         ]
      );
   }
}