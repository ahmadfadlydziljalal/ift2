<?php

use app\enums\TextLinkEnum;
use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $links array */
/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @see app\controllers\QuotationController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="quotation-view">

        <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
            <h1><?= Html::encode($model->getNomorDisplay()) ?></h1>
            <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
                <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
                <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="d-flex flex-row gap-2 mb-3">
            <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
                'class' => 'btn btn-outline-success',
                'target' => '_blank',
                'rel' => 'noopener noreferrer'
            ]) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>

        <div class="position-relative">
            <div class="row">

                <div class="col-sm-12 col-md-9">
                    <div class="d-flex flex-column gap-3">
                        <?= $this->render('_view_quotation', ['model' => $model]) ?>
                        <?= $this->render('_view_summary', ['model' => $model]) ?>
                        <?= $this->render('_view_quotation_barang', ['model' => $model]) ?>
                        <?= $this->render('_view_quotation_service', ['model' => $model]) ?>
                        <?= $this->render('_view_quotation_term_and_condition', ['model' => $model]) ?>
                        <?= $this->render('_view_form_job', ['model' => $model]) ?>
                        <?= $this->render('_view_delivery_receipt', ['model' => $model]) ?>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="position-fixed">
                        <div class="card shadow border-0" style="min-width: 16rem; max-width: 18rem">

                            <div class="list-group">
                                <?php
                                foreach ($links as $link) {
                                    echo Html::a('<i class="bi bi-arrow-left-circle"></i> ' . Inflector::humanize(str_replace("-", " ", $link)), '#' . $link, [
                                        'class' => 'list-group-item list-group-item-action'
                                    ]);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php

$js = <<<JS
jQuery(document).ready(function() {
  jQuery('.list-group-item').click(function(e) {
    e.preventDefault();
    jQuery('html, body').animate({
        scrollTop: $(jQuery(this).attr('href')).position().top
    }, 300);
    
  });
});
JS;
$this->registerJs($js);