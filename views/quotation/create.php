<?php
/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @see app\controllers\QuotationController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>