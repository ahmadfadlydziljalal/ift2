<?php

namespace app\models\form;

use app\components\helpers\ArrayHelper;
use app\models\Barang;
use Yii;
use yii\base\Model;

class PrintStockMultipleStickerForm extends Model {

    const DEFAULT_FORMAT_OPTIONS = [
        '50*70' => [
            'width'       => '50',
            'height'      => '70',
            "orientation" => "L",
        ],
        '60*80' => [
            'width'       => '60',
            'height'      => '80',
            "orientation" => "P",
        ],
        '40*60' => [
            'width'       => '40',
            'height'      => '60',
            "orientation" => "L",
        ]
    ];

    private int $width = 50;
    private int $height = 70;
    private ?string $orientation = 'L';

    public array $partNumbers = [];
    public ?string $format = null;


    public function rules(): array {
        return [
            ['format', 'in', 'range' => array_keys(static::getFormatOptions())],
            [['partNumbers'], 'required'],
        ];
    }

    /**
     * @return string[]
     */
    public static function getFormatOptions($map = true): array {

        $from = fn($format) => $format['width'] . '*' . $format['height'];
        $to = fn($format) => $format['width'] . '*' . $format['height'] . ' (' . $format['orientation'] . ')';

        $formats = Yii::$app->settings->get('sticker-formats', 'stock', []);
        return !$map ? $formats : (!empty($formats) ?
            ArrayHelper::map($formats, $from, $to) :
            ArrayHelper::map(static::DEFAULT_FORMAT_OPTIONS, $from, $to));

    }

    /**
     * @return Barang[]
     */
    public function generateBarangsModel(): array {
        return Barang::find()->where(['IN', 'id', array_map('intval', $this->partNumbers)])
            ->all();
    }

    public function setPageAttributes(?string $format): void {

        $formats = static::getFormatOptions(false);

        $this->orientation = $formats[$format]['orientation'];
        $this->height = $formats[$format]['orientation'] == 'L' ? (int)$formats[$format]['height'] : (int)$formats[$format]['width'];
        $this->width = $formats[$format]['orientation'] == 'L' ? (int)$formats[$format]['width'] : (int)$formats[$format]['height'];

    }

    public function getWidth(): int {
        return $this->width;
    }

    public function getHeight(): int {
        return $this->height;
    }

    public function getOrientation(): ?string {
        return $this->orientation;
    }
}