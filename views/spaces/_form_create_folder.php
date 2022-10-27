<?php


/* @var $this View */

/* @var $model DynamicModel */

use app\widgets\BreadcrumbsFlySystem;
use kartik\form\ActiveForm;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Buat Folder';
$this->params['breadcrumbs'][] = ['label' => 'Spaces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="space-create-folder">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo BreadcrumbsFlySystem::widget([
        'keyUrl' => 'root'
    ]); ?>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'nama_folder'); ?>

    <?= Html::submitButton('<i class="bi bi-plus-circle"></i> Buat', [
        'class' => 'btn btn-primary'
    ]) ?>


    <?php ActiveForm::end() ?>
</div>