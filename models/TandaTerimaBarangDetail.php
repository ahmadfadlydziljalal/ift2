<?php

namespace app\models;

use app\models\base\TandaTerimaBarangDetail as BaseTandaTerimaBarangDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tanda_terima_barang_detail".
 */
class TandaTerimaBarangDetail extends BaseTandaTerimaBarangDetail
{

   public ?int $barangId = null;
   public ?string $barangNama = null;
   public ?float $totalQuantityTerima = null;

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


}