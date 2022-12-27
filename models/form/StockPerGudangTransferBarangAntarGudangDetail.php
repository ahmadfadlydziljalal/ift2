<?php

namespace app\models\form;

use yii\base\Model;

class StockPerGudangTransferBarangAntarGudangDetail extends Model
{
   public ?string $gudangTujuan = null;
   public ?string $quantityIn = null;
   public ?string $block = null;
   public ?string $rak = null;
   public ?string $tier = null;
   public ?string $row = null;
   public ?string $catatan = null;

   public function rules(): array
   {
      return [
         [['gudangTujuan', 'quantityIn'], 'required'],
         [['block', 'rak', 'tier', 'row', 'catatan'], 'safe']
      ];
   }

}