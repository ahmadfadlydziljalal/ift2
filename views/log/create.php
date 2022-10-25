<?php
/* @var $this yii\web\View */
/* @var $model app\models\Log */
/* @see app\controllers\LogController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Log';
$this->params['breadcrumbs'][] = ['label' => 'Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>