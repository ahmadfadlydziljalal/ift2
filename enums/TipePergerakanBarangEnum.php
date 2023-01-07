<?php

namespace app\enums;

use app\models\Status;
use yii\helpers\Inflector;

enum TipePergerakanBarangEnum: int
{
   case START_PERTAMA_KALI_PENERAPAN_SISTEM = 0;
   case IN = 10;
   case MOVEMENT = 15;
   case MOVEMENT_FROM = 20;
   case MOVEMENT_TO = 30;
   case PEMBATALAN = 40;
   case OUT = 50;

   public static function getStatus(self $value): Status
   {
      return Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => Inflector::slug(str_replace('_', '-', $value->name))
      ]);
   }
}