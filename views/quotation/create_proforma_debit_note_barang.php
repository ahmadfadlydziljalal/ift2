<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaDebitNote|null */
/* @var $modelsDetail ProformaDebitNoteDetailBarang[] */

/* @see \app\controllers\QuotationController::actionCreateProformaDebitNoteDetailBarang() */

use app\models\ProformaDebitNote;
use app\models\ProformaDebitNoteDetailBarang;
use app\models\Quotation;
use yii\web\View;

$this->title = 'Tambah Proforma Debit Note Barang';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $quotation->id, '#' => 'quotation-tab-tab7']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="quotation-create">

    <h1><?= $quotation->getNomorDisplay() ?> | <?= $model->nomor ?></h1>

   <?= $this->render('_form_proforma_debit_note_barang', [
      'quotation' => $quotation,
      'model' => $model,
      'modelsDetail' => $modelsDetail
   ]) ?>

</div>