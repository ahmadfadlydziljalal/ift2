<?php

namespace app\models\form;

use yii\base\Model;

class ReportStockPerGudangBarangMasukDariTandaTerima extends Model
{
   public ?string $nomor = null;
   public ?string $classNameModel = null;

   public function init()
   {
      parent::init();
   }

   public function rules(): array
   {
      return [
         [['nomor'], 'required']
      ];
   }

   public function getModel()
   {
      return $this->classNameModel::findOne($this->nomor);
   }

}