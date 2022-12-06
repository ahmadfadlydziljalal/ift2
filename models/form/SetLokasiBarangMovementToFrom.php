<?php

namespace app\models\form;

use yii\base\Model;

class SetLokasiBarangMovementToFrom extends Model
{
   public ?int $tipePergerakanToId = null;
   public ?string $quantityTo = null;
   public ?string $blockTo = null;
   public ?string $rakTo = null;
   public ?string $tierTo = null;
   public ?string $rowTo = null;

   public function rules(): array
   {
      return [
         [['tipePergerakanToId',
            'quantityTo',
            'blockTo',
            'rakTo',
            'tierTo',
            'rowTo',], 'required']
      ];
   }
}