<?php

namespace app\enums;

use app\models\Card;
use yii\web\NotFoundHttpException;

/**
 * Metode penulisan lokasi barang | product yang disetujui oleh pemilik usaha
 * Frontend harus mengirimkan secara berurutan
 *
 * GUDANG | BLOCK | RAK | TIER | ROW
 *
 * */
enum CaraPenulisanLokasiEnum: int
{
   case GUDANG = 0;
   case BLOCK = 10;
   case RAK = 20;
   case TIER = 30;
   case ROW = 40;

   /**
    * @throws NotFoundHttpException
    */
   public static function getDropdown(self $value): array
   {
      return match ($value) {
         self::GUDANG => self::getGudangItem(),
         self::BLOCK => self::getFormatAbjad(),
         self::RAK, self::TIER, self::ROW => self::getFormatNumberLeadZero(),
      };
   }

   /**
    * @return array
    */
   private static function getFormatAbjad(): array
   {
      $range = range('A', 'Z');
      return array_combine(array_values($range), $range);
   }

   /**
    * @return array
    */
   private static function getFormatNumberLeadZero(): array
   {
      $range = range(1, 99);
      $data = [];
      array_walk($range, function ($item) use (&$data) {
         $lead = str_pad((string)$item, 2, '0', STR_PAD_LEFT);
         $data[$lead] = $lead;
      });
      return $data;
   }

   /**
    * @return array
    * @throws NotFoundHttpException
    */
   private static function getGudangItem(): array
   {
      return Card::find()->map(Card::GET_ONLY_WAREHOUSE);
   }


}