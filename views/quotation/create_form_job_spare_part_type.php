<?php

/* @var $quotationFormJobModel app\models\QuotationFormJob */
/* @var $models app\models\QuotationFormJobSparePart[] */

/* @var $this yii\web\View */

/* @see \app\controllers\QuotationController::actionCreateFormJobServicePartType() */

use yii\helpers\Html;

$this->title = 'Definisi - Spare Part  - ' . $quotationFormJobModel->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $quotationFormJobModel->quotation->nomor,
    'url'   => ['view', 'id' => $quotationFormJobModel->quotation->id, '#' => 'quotation-tab-tab4']
];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="quotation-form-job-spare-part-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form_form_job_spare_part', [
        'models'                => $models,
        'quotationFormJobModel' => $quotationFormJobModel,
    ]) ?>
</div>