<?php
/* @var $this yii\web\View */
/* @var $model app\models\CardPersonInCharge */
/* @see app\controllers\CardPersonInChargeController::actionCreate() */

use yii\helpers\Html;

$this->title = 'Tambah P.I.C';
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['/card/index']];
$this->params['breadcrumbs'][] = ['label' => $model->card->nama, 'url' => ['/card/view', 'id' => $model->card->id]];
$this->params['breadcrumbs'][] = 'Tambah P.I.C';
?>

<div class="card-person-in-charge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>