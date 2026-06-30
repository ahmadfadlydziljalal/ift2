<?php

namespace app\models\form;

use app\models\Barang;
use Yii;
use yii\base\Model;

class PrintStockMultipleStickerForm extends Model {

    public array $partNumbers = [];
    public ?string $format = null;
    public ?string $orientation = null;

    public function rules(): array {
        return [
            ['format', 'in', 'range' => array_keys($this->getFormatOptions())],
            ['orientation', 'in', 'range' => array_keys($this->getOrientationOptions())],
            [['partNumbers'], 'required'],
        ];
    }

    /**
     * @return string[]
     */
    public function getFormatOptions(): array {
        return Yii::$app->settings->get('sticker-formats', 'stock', [
            '40*60' => "40*60",
        ]);
    }

    /**
     * @return string[]
     */
    public function getOrientationOptions(): array {
        return [
            'L' => 'Landscape',
            'P' => 'Portrait',
        ];
    }

    /**
     * @return Barang[]
     */
    public function generateBarangsModel(): array {
        return Barang::find()->where(['IN', 'id', array_map('intval', $this->partNumbers)])
            ->all();
    }
}