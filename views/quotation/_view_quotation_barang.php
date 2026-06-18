<?php


/* @var $this View */

/* @var $model Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

?>


<div id="barang">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">

            <h3>Barang</h3>

            <div class="ms-auto">
                <?php if (!$model->quotationBarangs) : ?>

                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-barang-quotation', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-barang-quotation', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-barang-quotation', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail quotation barang ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>
        <?= $this->render('_view_quotation_barang_table', [
            'model' => $model,
        ]) ?>
    </div>
</div>