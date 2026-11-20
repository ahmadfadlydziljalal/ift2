<?php

namespace app\models\form;

use yii\base\Model;

/**
 * Satu baris lokasi pada form Start Barang.
 */
class BarangStartLokasi extends Model
{
    public $quantity;
    public $cardId;
    public $block;
    public $rak;
    public $tier;
    public $row;
    public $catatan;

    public function rules(): array
    {
        return [
            [['quantity', 'cardId', 'block', 'rak', 'tier', 'row'], 'required'],
            ['quantity', 'number', 'min' => 0.01],
            ['cardId', 'integer'],
            [['block', 'rak', 'tier', 'row'], 'string', 'max' => 8],
            ['catatan', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'quantity' => 'Quantity',
            'cardId'   => 'Gudang',
            'block'    => 'Block',
            'rak'      => 'Rak',
            'tier'     => 'Tier',
            'row'      => 'Row',
            'catatan'  => 'Catatan',
        ];
    }
}
