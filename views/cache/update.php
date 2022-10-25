<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cache */
/* @see app\controllers\CacheController::actionUpdate() */

$this->title = 'Update Cache: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cache', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="cache-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>