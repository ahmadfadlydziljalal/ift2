<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation|string|ActiveRecord */


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="row">
    <div class="col-12 mb-3">
        <div class="table-responsive">
            <?php
            if ($model->quotationDeliveryReceipts) {
                echo ListView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query'      => $model->getQuotationDeliveryReceipts(),
                        'pagination' => false,
                        'sort'       => false
                    ]),
                    'itemView'     => '_item_quotation_deliver_receipt', /** @see views/quotation/_item_quotation_deliver_receipt.php */
                    'layout'       => '{items}',
                    'options'      => [
                        'class' => 'd-flex flex-column gap-3'
                    ]
                ]);
            } else {
                echo Html::tag('p', 'Belum ada delivery receipt', [
                    'class' => 'text-danger font-weight-bold'
                ]);
            }
            ?>
        </div>
    </div>

</div>
