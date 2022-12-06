<?php

namespace app\models\form;

use yii\base\Model;

class SetLokasiBarangMovementFromForm extends Model
{

   public ?int $tipePergerakanFromId = null;
   public ?string $quantityFrom = null;
   public ?string $blockFrom = null;
   public ?string $rakFrom = null;
   public ?string $tierFrom = null;
   public ?string $rowFrom = null;


   public function rules(): array
   {
      return [
         [[
            'tipePergerakanFromId',
            'quantityFrom',
            'blockFrom',
            'rakFrom',
            'tierFrom',
            'rowFrom',


         ], 'required']
      ];
   }
}