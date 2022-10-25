<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @see app\controllers\CardController::actionUpdate() */

$this->title = 'Update Card: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>