<?php

/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\web\View;


?>

<?php if ($model->quotationFormJob) : ?>
    <?= $this->render('_view_form_job_header', ['model' => $model]) ?>
    <hr/>
    <?= $this->render('_view_form_job_jobs_and_spare_part', ['model' => $model]) ?>
    <hr/>
    <div class="row row-cols-1 mb-2">
        <div class="col">
            <p>Remarks</p>
            <?= !empty($model->quotationFormJob->remarks) ? nl2br($model->quotationFormJob->remarks) : 'No Remarks!' ?>
        </div>
    </div>
<?php else : ?>
    <p class="text-danger fw-bold">Belum ada form job</p>
<?php endif; ?>
