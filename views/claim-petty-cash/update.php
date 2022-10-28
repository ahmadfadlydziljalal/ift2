<?php

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */
/* @var $modelsDetail app\models\ClaimPettyCashNota */
/* @var $modelsDetailDetail app\models\ClaimPettyCashNotaDetail */

use yii\helpers\Html;
$this->title = 'Update Claim Petty Cash: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Claim Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="claim-petty-cash-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
        'modelsDetailDetail' => $modelsDetailDetail,
    ]) ?>

</div>