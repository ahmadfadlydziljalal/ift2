<?php

namespace app\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapIconAsset;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

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
      YiiAsset::class,
      BootstrapAsset::class,
      BootstrapIconAsset::class,
      BootstrapPluginAsset::class,
   ];
}