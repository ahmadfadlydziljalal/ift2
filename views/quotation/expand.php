<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation */

use yii\bootstrap5\Tabs;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="quotation-expand d-flex flex-column gap-2">

    <?php
    echo Tabs::widget([
        'options'           => [
            'id'   => 'quotation-tab-' . $model->id,
            'role' => 'tablist'
        ],
        'tabContentOptions' => [
            'class' => 'col-12 pt-0'
        ],
        'itemOptions'       => [
            'class' => 'p-0 '
        ],
        'headerOptions'     => [
            'class' => 'p-0 text-nowrap text-start '
        ],
        'items'             => [
            [
                'label'   => 'Barang',
                'content' => $this->render('_view_quotation_barang_table', ['model' => $model]),
                'active'  => true,
            ],
            [
                'label'   => 'Service',
                'content' => $this->render('_view_quotation_service_table', ['model' => $model]),
            ],
            [
                'label'   => 'Term & Condition',
                'content' => $this->render('_view_quotation_term_and_condition_table', ['model' => $model]),
            ],
            [
                'label'   => ' Form Job',
                'content' => $this->render('_view_form_job_header', ['model' => $model]) .
                    $this->render('_view_form_job_content', ['model' => $model]) .
                    $this->render('_view_form_job_footer', ['model' => $model])
            ],
            [
                'label'   => ' Delivery Receipt',
                'content' => $model->quotationDeliveryReceipts
                    ? ListView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query'      => $model->getQuotationDeliveryReceipts(),
                            'pagination' => false,
                            'sort'       => false
                        ]),
                        'itemView'     => '_item_item_quotation_deliver_receipt', /** @see views/quotation/_item_quotation_deliver_receipt.php */
                        'layout'       => '{items}',
                        'options'      => [
                            'class' => 'd-flex flex-column gap-3'
                        ]
                    ])
                    : Html::tag('p', 'Belum ada delivery receipt', ['class' => 'text-danger font-weight-bold'])
            ],
        ],
    ]);
    ?>
</div>
