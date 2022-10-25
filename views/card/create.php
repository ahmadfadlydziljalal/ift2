<?php
/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @see app\controllers\CardController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Card';
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>