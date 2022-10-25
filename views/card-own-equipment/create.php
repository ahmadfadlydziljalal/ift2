<?php
/* @var $this yii\web\View */
/* @var $model app\models\CardOwnEquipment */

/* @see app\controllers\CardOwnEquipmentController::actionCreate() */

use yii\helpers\Html;

$this->title = 'Tambah Equipment';
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['/card/index']];
$this->params['breadcrumbs'][] = ['label' => $model->card->nama, 'url' => ['/card/view', 'id' => $model->card->id]];
$this->params['breadcrumbs'][] = 'Tambah Equipment';
?>

<div class="card-own-equipment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>