<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/v2/dist';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/site.css'
    ];
    public $js = [
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapIconAsset',
    ];
}
