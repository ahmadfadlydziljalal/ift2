<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @see \app\controllers\QuotationController::actionCreateTermAndCondition() */

/* @var $models array */

use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Create Term & Condition: ' . $quotation->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Create';
?>

<div class="create-quotation">

    <?= Html::tag('h1', Html::encode($this->title)) ?>
    <?= $this->render('_form_term_and_condition', [
        'models' => $models,
        'quotation' => $quotation,
    ]) ?>

</div>