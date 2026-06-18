<?php

/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
    <div class="col mb-2">
        <h4><i class="bi bi-box "></i> Jobs</h4>
        <?php if (empty($model->quotationFormJob?->getQuotationFormJobJobs()->count())) : ?>
            <p class="text-danger fw-bold">Belum ada form job</p>
        <?php else : ?>
            <?= $this->render('_view_form_job_jobs_table', [
                'model' => $model
            ]); ?>
        <?php endif; ?>

    </div>
    <div class="col mb-2">
        <h4><i class="bi bi-box "></i> Spare Part Estimation</h4>
        <?php if (empty($model->quotationFormJob?->getQuotationFormJobSpareParts()->count())) : ?>
            <p class="text-danger fw-bold">Belum ada form job</p>
        <?php else : ?>
            <?= $this->render('_view_form_job_spare_part_table', [
                'model' => $model
            ]); ?>
        <?php endif; ?>
    </div>
</div>
