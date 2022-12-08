<?php


/* @var $this View */
/* @var $model ProformaInvoice */
/* @var $quotation Quotation */

/* @see \app\controllers\QuotationController::actionCreateProformaDebitNote() */

use app\models\ProformaInvoice;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Proforma Debit Note: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Tambah Proforma Debit Note';

?>

<div class="quotation-create-proforma-debit-note">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_proforma_debit_note', [
      'model' => $model
   ]) ?>


</div>