<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaInvoice */
/* @var $modelsDetail ProformaInvoiceDetailService[] */

/* @see \app\controllers\QuotationController::actionCreateProformaDebitNoteDetailService() */

use app\models\ProformaInvoice;
use app\models\ProformaInvoiceDetailService;
use app\models\Quotation;
use yii\web\View;

$this->title = 'Tambah Proforma Debit Note Service';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $quotation->id, '#' => 'quotation-tab-tab7']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-create">

    <h1><?= $quotation->getNomorDisplay() ?> | <?= $model->nomor ?></h1>

   <?= $this->render('_form_proforma_debit_note_service', [
      'quotation' => $quotation,
      'model' => $model,
      'modelsDetail' => $modelsDetail
   ]) ?>

</div>