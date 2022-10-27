<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Url;

class BreadcrumbsFlySystem extends Widget
{

    public $keyUrl;

    public function init()
    {
        parent::init();
        if ($this->keyUrl === null) {
            $this->keyUrl = 'path';
        }
    }

    public function run()
    {
        return $this->make();
    }

    public function make()
    {
        $queryParamsPath = Yii::$app->request->queryParams[$this->keyUrl] ??
            Yii::$app->params['awsRootPath'];
        $links = explode('/', $queryParamsPath);
        $hold = [];

        $links = array_map(function ($el) use (&$hold) {
            $hold[] = $el;
            return [
                'label' => $el,
                'url' => Url::to(['spaces/index', 'path' => implode('/', $hold)])
            ];
        }, $links);

        return Breadcrumbs::widget([
            'links' => $links,
            'encodeLabels' => false,
            'options' => [
                'class' => 'm-0 mb-2',
            ],
            'homeLink' => [
                'label' => '<i class="bi bi-server"></i>'
            ],
        ]);
    }


}