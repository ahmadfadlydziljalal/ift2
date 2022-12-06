<?php


/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="card bg-transparent " id="master">
    <div class="card-body">


       <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-primary mb-3']) ?>

       <?php try {
          echo DetailView::widget([
             'model' => $model,
             'options' => [
                'class' => 'table table-bordered table-detail-view'
             ],
             'attributes' => [
                'nomor',
                [
                   'attribute' => 'mata_uang_id',
                   'value' => $model->mataUang->nama
                ],
                'tanggal:date',
                [
                   'attribute' => 'customer_id',
                   'value' => $model->customer->nama
                ],
                'tanggal_batas_valid:date',
                'attendant_1',
                'attendant_phone_1',
                'attendant_email_1:email',
                'attendant_2',
                'attendant_phone_2',
                'attendant_email_2:email',
                'vat_percentage',
                [
                   'attribute' => 'rekening_id',
                   'value' => $model->rekening->atas_nama,
                   'format' => 'nText'
                ],
                [
                   'attribute' => 'signature_orang_kantor_id',
                   'value' => $model->signatureOrangKantor->nama,
                ],
                [
                   'attribute' => 'materai_fee',
                   'format' => ['decimal', 2],
                   'value' => $model->materai_fee,
                   'contentOptions' => [
                      'class' => 'text-end'
                   ]
                ]
             ],
          ]);
       } catch (Throwable $e) {
          echo $e->getMessage();
       }
       ?>
    </div>
</div>