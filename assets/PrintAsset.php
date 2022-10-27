<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PrintAsset extends AssetBundle
{
    public $sourcePath = '@themes/v2/dist';
    public $baseUrl = '@web';
    public $css = [
        'css/print.css'
    ];
    public $js = [
        'js/print.js'
    ];
    public $depends = [];
}