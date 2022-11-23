<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionCreateBarangQuotation() */

/* @var $models QuotationBarang[]|array */

use app\models\Quotation;
use app\models\QuotationBarang;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Quotation Barang ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_quotation_barang', [
        'models' => $models,
        'quotation' => $quotation,
    ]) ?>
</div>