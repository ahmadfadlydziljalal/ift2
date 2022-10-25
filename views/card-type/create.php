<?php
/* @var $this yii\web\View */
/* @var $model app\models\CardType */
/* @see app\controllers\CardTypeController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Card Type';
$this->params['breadcrumbs'][] = ['label' => 'Card Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>