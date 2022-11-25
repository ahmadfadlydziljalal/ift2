<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionCreateDeliveryReceipt() */

/* @var $model QuotationDeliveryReceipt */


use app\models\Quotation;
use app\models\QuotationDeliveryReceipt;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Tambah Delivery Receipt : Quotation ' . $quotation->getNomorDisplay();
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Tambah Delivery Receipt';

?>

<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form_delivery_receipt', [
      'model' => $model,
      'quotation' => $quotation,
   ]) ?>
</div>