<?php
/* @var $this yii\web\View */
/* @var $model app\models\Satuan */
/* @see app\controllers\SatuanController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Satuan';
$this->params['breadcrumbs'][] = ['label' => 'Satuan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="satuan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>