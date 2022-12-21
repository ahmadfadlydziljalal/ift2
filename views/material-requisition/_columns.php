<?php

use app\models\Card;
use app\models\MaterialRequisition;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\grid\DataColumn;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\ButtonDropdown as ButtonDropdownAlias;
use yii\helpers\Url;

return [
   [
      'class' => 'yii\grid\SerialColumn',
   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],
   [
      'class' => 'kartik\grid\ExpandRowColumn',
      'width' => '50px',
      'detailUrl' => Url::toRoute(['material-requisition/expand-item']),
      'expandOneOnly' => true,
      'header' => '',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'nomor',
      'format' => 'text',
      'value' => function ($model) {
         /** @var MaterialRequisition $model */
         return $model->getNomorDisplay();
      }
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'vendor_id',
      'format' => 'text',
      'value' => 'vendor.nama',
      'filter' => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR)
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'tanggal',
      'format' => 'date',
      'filterType' => GridViewInterface::FILTER_DATE
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'remarks',
      'format' => 'nText',
   ],
   [
      'class' => DataColumn::class,
      'header' => 'Purchase Order',
      'format' => 'raw',
      'contentOptions' => [
         'class' => 'text-wrap',
         'style' => [
            'width' => '8rem'
         ]
      ],
      'value' => function ($model) {
         /** @var MaterialRequisition $model */
         if (!$model->purchaseOrdersNomor) {
            return '';
         }
         return $model->purchaseOrdersNomorAsHtml;
      },
   ],
//   [
//      'class' => DataColumn::class,
//      'attribute' => 'approved_by_id',
//      'format' => 'text',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'acknowledge_by_id',
//      'format' => 'text',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'created_at',
//      'format' => 'text',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'updated_at',
//      'format' => 'text',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'created_by',
//      'format' => 'text',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'updated_by',
//      'format' => 'text',
//   ],
   [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{actions}',
      'buttons' => [
         'actions' => function ($url, $model, $key) {
            return ButtonDropdown::widget([
               'encodeLabel' => false,
               'label' => 'Actions',
               'direction' => ButtonDropdownAlias::DIRECTION_RIGHT,
               'dropdown' => [
                  'encodeLabels' => false,
                  'items' => [

                     '<h6 class="dropdown-header">' . $model->nomor . '</h6>',
                     '<div class="dropdown-divider"></div>',
                     [
                        'label' => 'Print Material Request',
                        'linkOptions' => [
                           'target' => '_blank',
                           'rel' => 'noopener noreferrer'
                        ],
                        'url' => ['print-pdf', 'id' => $model->id],
                        'visible' => true,   // same as above
                     ],
                     [
                        'label' => 'Print Penawaran',
                        'linkOptions' => [
                           'target' => '_blank',
                           'rel' => 'noopener noreferrer'
                        ],
                        'url' => ['print-penawaran-to-pdf', 'id' => $model->id],
                        'visible' => true,   // same as above
                     ],
                     /* [
                         'label' => 'Print',
                         'linkOptions' => [
                            'target' => '_blank',
                            'rel' => 'noopener noreferrer'
                         ],
                         'url' => ['print', 'id' => $model->id],
                         'visible' => true,   // same as above
                      ],*/
                     '<div class="dropdown-divider"></div>',
                     [
                        'label' => Yii::t('yii', 'View'),
                        'url' => ['view', 'id' => $model->id],
                        'linkOptions' => [
                           'data' => [
                              'pjax' => '0',
                           ],
                        ],
                     ],
                     [
                        'label' => Yii::t('yii', 'Update'),
                        'url' => ['update', 'id' => $model->id],
                        'linkOptions' => [
                           'data' => [
                              'pjax' => '0',
                           ],
                        ],
                        'visible' => true,  // if you want to hide an item based on a condition, use this
                     ],
                     [
                        'label' => Yii::t('yii', 'Delete'),
                        'linkOptions' => [
                           'data' => [
                              'method' => 'post',
                              'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                           ],
                        ],
                        'url' => ['delete', 'id' => $model->id],
                        'visible' => true,   // same as above
                     ],
                  ],
                  'options' => [
                     'class' => 'dropdown-menu-right', // right dropdown
                  ],
               ],
               'buttonOptions' => [
                  'class' => 'btn-sm btn-outline-primary'
               ]
            ]);
         }
      ],
//      'template' => '{print} {view} {update} {delete}',
//      'buttons' => [
//         'print' => function ($url, $model) {
//            return Html::a('<i class="bi bi-printer-fill"></i>', ['material-requisition/print-to-pdf', 'id' => $model->id], [
//               'class' => 'print text-success',
//               'target' => '_blank',
//               'rel' => 'noopener noreferrer'
//            ]);
//         },
//      ],
   ],
];   