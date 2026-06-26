<?php

namespace app\models\form;

use app\models\Barang;
use yii\base\Model;

class PrintStockMultipleStickerForm extends Model {

    public array $partNumbers = [];

    public function rules(): array {
        return [
            [['partNumbers'], 'required']
        ];
    }

    /**
     * @return Barang[]
     */
    public function generateBarangsModel() {
        return Barang::find()->where(['IN', 'id', array_map('intval', $this->partNumbers)])
            ->all();
    }
}