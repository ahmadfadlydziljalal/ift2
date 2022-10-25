<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class KolomDenganMataUang extends Widget
{

    public array $value;

    public function run(): string
    {
        parent::run();

        $tag = Html::beginTag('table', [
                'class' => 'p-0 m-0',
                'style' => [
                    'border-collapse' => 'none',
                    'width' => '8em',
                ]
            ]
        );

        $tag .= Html::beginTag('tr');

        $tag .= Html::tag('td', $this->value[0], [
            'class' => 'border-0 p-0 m-0 text-start',
            'style' => [
                'width' => '3%',
            ]
        ]);

        $tag .= Html::tag('td', $this->value[1], [
            'class' => 'p-0 m-0',
            'style' => [
                'width' => '97%',
            ]
        ]);

        $tag .= Html::endTag('tr');

        $tag .= Html::endTag('table');

        return $tag;
    }
}