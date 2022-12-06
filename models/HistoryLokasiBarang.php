<?php

namespace app\models;

use app\models\base\HistoryLokasiBarang as BaseHistoryLokasiBarang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "history_lokasi_barang".
 */
class HistoryLokasiBarang extends BaseHistoryLokasiBarang
{

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
         ]
      );
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'id' => 'ID',
         'card_id' => 'Gudang | Warehouse',
         'tanda_terima_barang_detail_id' => 'Tanda Terima Barang Detail',
         'tipe_pergerakan_id' => 'Tipe Pergerakan',
      ]);
   }
}