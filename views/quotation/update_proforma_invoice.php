<?php


/* @var $this View */
/* @var $model ProformaInvoice */
/* @var $quotation Quotation */

/* @see \app\controllers\QuotationController::actionUpdateProformaInvoice() */

use app\models\ProformaInvoice;
use app\models\Quotation;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Update Proforma Invoice: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update Proforma Invoice';
?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_proforma_invoice', [
      'model' => $model,
   ]) ?>
</div>