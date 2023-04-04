<?php

namespace app\enums;

use yii\helpers\Inflector;

enum PotensiCardOwnEquipmentServiceEnum: string
{
   case SAFE = 'Safe';
   case SERVICE = 'Service';
   case BELUM_ATAU_TIDAK_PERNAH_SERVICE = 'Belum atau tidak pernah service';

   /**
    * @return array
    */
   public static function map(): array
   {
      $result = [];
      foreach (self::cases() as $case) {
         $result[$case->value] = Inflector::humanize($case->value);
      }
      return $result;
   }

   public function label(): string
   {
      return static::getLabel($this);
   }

   public static function getLabel(string $text): string
   {
      return match ($text) {
         self::SAFE->value => '<div class="d-flex gap-1 text-primary"><i class="bi bi-check"></i> Safe</div>',
         self::SERVICE->value => '<div class="d-flex gap-1 text-danger"><i class="bi bi-x-circle"></i> Service</div>',
         self::BELUM_ATAU_TIDAK_PERNAH_SERVICE->value => '<div class="d-flex gap-1 text-secondary"><i class="bi bi-shield-minus"></i> Belum</div>',
      };
   }

}