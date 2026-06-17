<?php

namespace app\widgets\stock;

use app\models\Stock;
use Exception;
use yii\base\Widget;

class StockItem extends Widget {
    public ?Stock $model = null;
    public ?string $additionalView = null;

    /**
     * @throws Exception
     */
    public function init(): void {
        parent::init();
        if ($this->model === null) {
            throw new Exception('Stock model is required');
        }
    }


    public function run() {
        return $this->render('index', [
            'model'          => $this->model,
            'additionalView' => $this->additionalView
        ]);
    }
}