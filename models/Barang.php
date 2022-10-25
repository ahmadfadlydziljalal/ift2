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

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'id' => 'ID',
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