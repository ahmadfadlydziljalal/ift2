<?php

namespace app\assets;

use yii\web\AssetBundle;

class Bootstrap5VerticalTabs extends AssetBundle
{

   public $basePath = '@webroot';
   public $baseUrl = '@web';

   public $css = [
      'https://cdn.jsdelivr.net/npm/bootstrap-5-vertical-tabs@2.0.0/dist/b5vtabs.min.css'
   ];

   public $js = [
      'js/vertical-tab.js'
   ];

   public $cssOptions = [
      'integrity' => 'sha384-AsoWNxsuu73eGp2MPWHa77155fyqP9rueKOeG4t2d/AD4eyBqL20TClzfbAkrul4',
      'crossorigin' => 'anonymous'
   ];

   public $depends = [
      ThemeAsset::class
   ];
}