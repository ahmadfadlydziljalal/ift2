<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @var $models QuotationFormJob[] */

/* @see \app\controllers\QuotationController::actionUpdateFormJob() */

use app\models\Quotation;
use app\models\QuotationFormJob;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Update Form Job: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form_form_job', [
        'models' => $models,
        'quotation' => $quotation,
    ]); ?>

</div>