<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardPersonInCharge */
/* @see app\controllers\CardPersonInChargeController::actionUpdate() */

$this->title = 'Update P.I.C: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['/card/index']];
$this->params['breadcrumbs'][] = ['label' => $model->card->nama, 'url' => ['/card/view', 'id' => $model->card->id]];
$this->params['breadcrumbs'][] = 'Update P.I.C';
?>

<div class="card-person-in-charge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>