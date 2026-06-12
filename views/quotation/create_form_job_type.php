<?php

/* @var $quotationFormJobModel app\models\QuotationFormJob|null */
/* @var $models array|app\models\QuotationFormJobJobs[] */
/* @var $this yii\web\View */

/* @see \app\controllers\QuotationController::actionCreateFormJobType() */

use app\enums\QuotationFormJobJobsTypeEnum;
use yii\helpers\Html;

$this->title = 'Definisi - ' . QuotationFormJobJobsTypeEnum::labelOf(Yii::$app->request->get('type')) . ' - ' . $quotationFormJobModel->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $quotationFormJobModel->quotation->nomor,
    'url'   => ['view', 'id' => $quotationFormJobModel->quotation->id, '#' => 'quotation-tab-tab4']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-form-job-jobs-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form_form_job_jobs', [
        'models'                => $models,
        'quotationFormJobModel' => $quotationFormJobModel,
    ]) ?>
</div>