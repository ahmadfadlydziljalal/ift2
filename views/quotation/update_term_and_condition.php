<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionUpdateTermAndCondition() */

/* @var $models QuotationTermAndCondition[]|array */

use app\models\Quotation;
use app\models\QuotationTermAndCondition;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Update Term & Condition: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="quotation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_term_and_condition', [
        'models' => $models,
        'quotation' => $quotation,
    ]) ?>
</div>