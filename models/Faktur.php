<?php

namespace app\models;

use app\models\base\Faktur as BaseFaktur;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "faktur".
 */
class Faktur extends BaseFaktur
{

    public ?string $total = null;

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors,
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor_faktur', // required
                    'value' => '?' . '/' . date('Y') , // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],
            ]
        );
    }

    public function rules(): array
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'jenis_transaksi_id' => 'Transaksi',
            'card_id' => 'Customer',
            'toko_saya_id' => 'Toko Saya',
            'tanggal_faktur' => 'Tgl Faktur',
            'rekening_id' => 'Rekening',
        ]);
    }

    public function getSumSubtotal()
    {
        return array_sum(
            array_map(function ($el) {
                return $el->quantity * $el->harga_barang;
            }, $this->fakturDetails)
        );
    }


}