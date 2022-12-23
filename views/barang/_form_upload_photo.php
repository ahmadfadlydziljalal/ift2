<?php

use app\models\Barang;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\web\View;


/* @var $this View */
/* @var $model Barang */
/* @see \app\controllers\BarangController::actionUploadPhoto() */
/* @see \app\controllers\BarangController::actionHandleUploadPhoto() */

$this->title = "Upload Photo ";
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

try {
   echo FileInput::widget([
      'id' => 'file_data',
      'name' => 'file_data',
      'options' => [
         'accept' => 'image/*',
         'multiple' => false
      ],
      'pluginOptions' => [
         'uploadClass' => 'btn btn-success',
         'uploadUrl' => Url::to(['handle-upload-photo']),
         'uploadExtraData' => [
            'id' => $model->id,
            'ift_number' => $model->ift_number
         ],
      ]
   ]);
} catch (Exception $e) {
   echo $e->getMessage();
} catch (Throwable $e) {
   echo $e->getMessage();
}