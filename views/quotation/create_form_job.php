<?php


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model QuotationFormJob */

/* @see \app\controllers\QuotationController::actionCreateFormJob() */

use app\models\Quotation;
use app\models\QuotationFormJob;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Form Job: Quotation ' . $quotation->getNomorDisplay();
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_form_job', [
        'model' => $model,
        'quotation' => $quotation,
    ]) ?>
</div>