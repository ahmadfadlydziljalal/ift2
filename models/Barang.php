<?php

namespace app\models;

use app\models\base\Barang as BaseBarang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "barang".
 */
class Barang extends BaseBarang
{

    public ?string $satuanHarga = null;
    public ?string $originalitasNama = null;
    public ?string $tipePembelianNama = null;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'ift_number', // required
                    'value' => 'IFT-' . '?', // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],
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

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'id' => 'ID',
                'tipe_pembelian_id' => 'Tipe Pembelian',
                'nama' => 'Nama',
                'part_number' => 'Part Number',
                'keterangan' => 'Keterangan',
                'ift_number' => 'IFT Number',
                'merk_part_number' => 'Merk Part Number',
                'originalitas_id' => 'Originalitas',
            ]
        );
    }
}