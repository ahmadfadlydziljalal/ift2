<?php

/* @var $this yii\web\View */
/* @var $model app\models\Faktur */

/* @var $modelsDetail app\models\FakturDetail */

use yii\helpers\Html;

$this->title = 'Update Faktur: ' . $model->nomor_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Faktur', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor_faktur, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faktur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>