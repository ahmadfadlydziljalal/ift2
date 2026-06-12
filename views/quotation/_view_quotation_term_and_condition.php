<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateTermAndCondition() */
/* @see \app\controllers\QuotationController::actionUpdateTermAndCondition() */
/* @see \app\controllers\QuotationController::actionDeleteTermAndCondition() */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

?>


<div id="term-and-condition">

    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">

            <h3>Term & Condition</h3>

            <div class="ms-auto">
                <?php if (!$model->quotationTermAndConditions) : ?>
                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-term-and-condition', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>
                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-term-and-condition', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-term-and-condition', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail term and condition ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider'     => new ActiveDataProvider([
                    'query'      => $model->getQuotationTermAndConditions(),
                    'pagination' => false,
                    'sort'       => false
                ]),
                'layout'           => '{items}',
                'headerRowOptions' => [
                    'class' => 'text-wrap text-center align-middle'
                ],
                'columns'          => [
                    [
                        'class' => SerialColumn::class,
                    ],
                    [
                        'class'     => DataColumn::class,
                        'attribute' => 'term_and_condition'
                    ]
                ],
                'showFooter'       => false,
            ]) ?>
        </div>
    </div>

</div>