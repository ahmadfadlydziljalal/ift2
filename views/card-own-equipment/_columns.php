<?php

use app\components\grid\ActionColumn;
use app\enums\PotensiCardOwnEquipmentServiceEnum;
use app\models\Card;
use app\models\CardOwnEquipment;
use kartik\date\DatePicker;
use kartik\grid\DataColumn;
use kartik\grid\GridViewInterface;
use yii\helpers\Html;
use yii\helpers\Url;

return [
   [
      'class' => 'yii\grid\SerialColumn',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   // [
   // 'class'=>'\kartik\grid\DataColumn',
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],
   [
      'class' => 'kartik\grid\ExpandRowColumn',
      'width' => '50px',
      'detailUrl' => Url::toRoute(['card-own-equipment/expand-item']),
      'expandOneOnly' => true,
      'header' => '',
      'contentOptions' => [
         'class' => 'align-top'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'card_id',
      'value' => 'card.nama',
      'filter' => Card::find()->map(Card::GET_ONLY_CUSTOMER),
      'format' => 'text',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'nama',
      'format' => 'text',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'lokasi',
      'format' => 'nText',
      'contentOptions' => [
         'class' => 'text-wrap',
      ],
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'tanggal_produk',
      'format' => 'date',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'serial_number',
      'format' => 'text',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'potensiService',
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-wrap'
      ],
      'format' => 'raw',
      'filter' => PotensiCardOwnEquipmentServiceEnum::map(),
      'value' => function ($model) {
         /** @var CardOwnEquipment $model */
         if (is_null($model->potensiService)) {
            return PotensiCardOwnEquipmentServiceEnum::BELUM_ATAU_TIDAK_PERNAH_SERVICE->value;
         }
         return PotensiCardOwnEquipmentServiceEnum::getLabel($model->potensiService);
      }
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'suggestionTanggalServiceSelanjutnya',
      'format' => 'raw',
      'filterType' => GridViewInterface::FILTER_DATE,
      'filterWidgetOptions' => [
         'type' => DatePicker::TYPE_INPUT
      ],
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'value' => function ($model) {

         /** @var CardOwnEquipment $model */
         if (is_null($model->suggestionTanggalServiceSelanjutnya)) {
            return '';
         }

         return $model->suggestionTanggalServiceSelanjutnya <= date('Y-m-d')
            ? Html::tag('span', Yii::$app->formatter->asDate($model->suggestionTanggalServiceSelanjutnya), ['class' => 'text-danger'])
            : Html::tag('span', Yii::$app->formatter->asDate($model->suggestionTanggalServiceSelanjutnya));
      }
   ],
   [
      'class' => ActionColumn::class,
      'dropdown' => true,
      'template' => '{add-history-service}{divider}{view}{update}{delete}',
      'buttons' => [

         'divider' => fn($url, $model, $key) => '<li><hr class="dropdown-divider"></li>',

         /** @see \app\controllers\CardOwnEquipmentController::actionAddHistoryService() */
         'add-history-service' => fn($url, $model, $key) => Html::a('<i class="bi bi-plus-circle"></i> Tambah History', $url, [
            'class' => 'dropdown-item',
            'data-pjax' => '0'
         ])

      ]
   ],
];   