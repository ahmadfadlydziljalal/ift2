<?php

use app\models\ProformaInvoice;
use app\models\ProformaInvoiceDetailBarang;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaInvoice */
/* @var $modelsDetail ProformaInvoiceDetailBarang[] */
/* @see \app\controllers\QuotationController::actionUpdateProformaInvoiceDetailBarang() */

$this->title = 'Update Proforma Invoice Barang';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $quotation->id, '#' => 'quotation-tab-tab8']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-create">

    <h1><?= $quotation->getNomorDisplay() ?> | <?= $model->nomor ?></h1>

   <?= $this->render('_form_proforma_invoice_barang', [
      'quotation' => $quotation,
      'model' => $model,
      'modelsDetail' => $modelsDetail
   ]) ?>

</div>