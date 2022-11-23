<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */

/* @var $models QuotationService[]|array */

use app\models\Quotation;
use app\models\QuotationService;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Update Quotation Service: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_quotation_service', [
        'models' => $models,
        'quotation' => $quotation,
    ]) ?>
</div>