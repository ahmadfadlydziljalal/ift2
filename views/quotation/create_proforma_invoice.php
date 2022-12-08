<?php


/* @var $this View */
/* @var $model ProformaInvoice */
/* @var $quotation Quotation */

/* @see \app\controllers\QuotationController::actionCreateProformaInvoice() */

use app\models\ProformaInvoice;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Proforma Invoice: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Tambah Proforma Invoice';

?>

<div class="quotation-create-proforma-invoice">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_proforma_invoice', [
      'model' => $model
   ]) ?>


</div>