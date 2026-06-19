<?php

namespace app\components;

use Da\QrCode\QrCode;
use yii\base\Component;

class QrCodeStockGenerator extends Component {

    public string $text;
    public ?string $filename = null;
    public int $size = 125;
    public float $margin = 5;

    private function generate(): QrCode {
        return (new QrCode($this->text))
            ->setSize($this->size)
            ->setMargin($this->margin);
    }

    public function toFile(): string {
        $qrCode = $this->generate();
        $path = sys_get_temp_dir() . '/' . $this->filename;
        $qrCode->writeFile($path);
        return $path;
    }

    public function toWriteDataUri(): string {
        $qrCode = $this->generate();
        return $qrCode->writeDataUri();
    }

}