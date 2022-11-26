<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionUpdateDeliveryOrderReceipt() */

/* @var $model QuotationDeliveryReceipt */

/* @var $modelsDetail QuotationDeliveryReceiptDetail[] */


use app\models\Quotation;
use app\models\QuotationDeliveryReceipt;
use app\models\QuotationDeliveryReceiptDetail;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Update Delivery Receipt: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_delivery_receipt', [
      'model' => $model,
      'quotation' => $quotation,
      'modelsDetail' => $modelsDetail,
   ]); ?>

</div>