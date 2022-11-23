<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @var $models QuotationBarang[] */

/* @see \app\controllers\QuotationController::actionUpdateBarangQuotation() */

use app\models\Quotation;
use app\models\QuotationBarang;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Update Quotation: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_quotation_barang', [
        'models' => $models,
        'quotation' => $quotation,
    ]) ?>
</div>