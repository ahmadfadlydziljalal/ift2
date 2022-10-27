<?php

use app\widgets\BreadcrumbsFlySystem;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */


$this->title = 'Upload File';
$this->params['breadcrumbs'][] = ['label' => 'Spaces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="karyawan-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo BreadcrumbsFlySystem::widget([
        'keyUrl' => 'root'
    ]); ?>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <?php
                    try {
                        echo FileInput::widget([
                            'id' => 'file_data',
                            'name' => 'file_data',
                            'options' => [
                                'accept' => '.pdf, .doc, .docx, .xls, .xlsx, .csv, .txt, .rtf, .jpg, .jpeg, .png',
                                'multiple' => true
                            ],
                            'pluginOptions' => [
                                'uploadClass' => 'btn btn-success',
                                'uploadUrl' => Url::to(['handle-upload']),
                                'uploadExtraData' => [
                                    'root' => $root
                                ],
                            ]
                        ]);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>