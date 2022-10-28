<?php

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */
/* @var $modelsDetail app\models\ClaimPettyCashNota */
/* @var $modelsDetailDetail app\models\ClaimPettyCashNotaDetail */

use yii\helpers\Html;
$this->title = 'Tambah Claim Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Claim Petty Cash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="claim-petty-cash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
        'modelsDetailDetail' => $modelsDetailDetail,
    ]) ?>

</div>