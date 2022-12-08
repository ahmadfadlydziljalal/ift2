<?php


/* @var $this View */
/* @var $model ProformaDebitNote */
/* @var $quotation Quotation */

/* @see \app\controllers\QuotationController::actionUpdateProformaDebitNote() */

use app\models\ProformaDebitNote;
use app\models\Quotation;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Update Proforma Debit Note: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update Proforma Debit Note';
?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_proforma_debit_note', [
      'model' => $model,
   ]) ?>
</div>