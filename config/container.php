<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\LinkPager as Bs5LinkPager;
use yii\data\Pagination;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

return [
   'definitions' => [
      Pagination::class => ['pageSize' => 10],
      LinkPager::class => Bs5LinkPager::class,
      GridView::class => [
         'headerRowOptions' => [
            'class' => 'text-nowrap text-center'
         ],
         'rowOptions' => [
            'class' => 'text-nowrap'
         ],
         'tableOptions' => [
            'class' => 'table table-bordered table-grid-view'
         ],
         'layout' =>
            '<div class="table-responsive">' .
            "{items}" .
            '</div>' .
            '<div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between border-1 border-top-0 align-items-center py-0 m-0 my-lg-3">' .
            "{pager}" .
            "{summary}" .
            '</div>',
         'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'prevPageLabel' => '<i class="bi bi-chevron-left small"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right small"></i>',
            'maxButtonCount' => 3,
         ],
         'summary' => "{begin, number}-{end, number} dari {totalCount, number} {totalCount, plural, one{item} other{items}}",
      ],
      \kartik\grid\GridView::class => [
         'headerRowOptions' => [
            'class' => 'text-nowrap text-center'
         ],
         'rowOptions' => [
            'class' => 'text-nowrap'
         ],
         'tableOptions' => [
            'class' => 'table table-grid-view'
         ],
         'panel' => false,
         'bordered' => true,
         'striped' => false,
         'headerContainer' => [],
         'responsive' => false,
         'responsiveWrap' => false,
         'resizableColumns' => false,
         /*'exportConfig' => [
             'html' => [],
             'csv' => [],
             'txt' => [],
             'xls' => [],
             'pdf' => [],
             'json' => [],
         ],*/
         'layout' =>
            '<div class="table-responsive">' .
            "{items}" .
            '</div>' .
            '<div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between border-1 border-top-0 align-items-baseline py-3 m-0">' .
            "{pager}" .
            "{summary}" .
            '</div>',
         'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'prevPageLabel' => '<i class="bi bi-chevron-left small"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right small"></i>',
            'maxButtonCount' => 3,
         ],
         'summary' => "{begin, number}-{end, number} dari {totalCount, number} {totalCount, plural, one{item} other{items}}",
      ],
      SerialColumn::class => [
         'contentOptions' => [
            'style' => [
               'text-align' => 'right',
               'vertical-align' => 'top'
            ]
         ],
      ],
      \kartik\grid\SerialColumn::class => [
         'contentOptions' => [
            'style' => [
               'text-align' => 'right',
               'vertical-align' => 'top'
            ]
         ],
      ],
      ActionColumn::class => [
         'header' => 'Aksi',
         'contentOptions' => [
            'class' => 'text-center'
         ],
      ],
      DetailView::class => [
         'options' => [
            'class' => 'table table-bordered table-detail-view'
         ]
      ],
      ListView::class => [
         'layout' =>
            "{items}" .
            '<div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-between border-1 border-top-0 align-items-center py-0 m-0 my-lg-3">' .
            "{pager}" .
            "{summary}" .
            '</div>'
         ,
      ],
      kartik\grid\ExpandRowColumn::class => [
         'expandIcon' => '<span class="bi bi-chevron-down"></span>',
         'collapseIcon' => '<span class="bi bi-chevron-up"></span>',
         //'detailRowCssClass' => '',
         'detailRowCssClass' => 'bg-white',
         'expandOneOnly' => true,
         'enableCache' => false,
         'vAlign' => 'middle',
         'allowBatchToggle' => false,
         'value' => function () {
            return GridViewInterface::ROW_COLLAPSED;
         },
         'detailAnimationDuration' => 100
      ],
      DatePicker::class => [
         'type' => DatePicker::TYPE_COMPONENT_APPEND,
         'pickerIcon' => '<i class="bi bi-calendar"></i>',
         'removeIcon' => '<i class="bi bi-x-lg"></i>',
         'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose' => true,
            'format' => 'dd-mm-yyyy'
         ]
      ],
      DateTimePicker::class => [
         'type' => DateTimePicker::TYPE_INPUT,
         'options' => [
            'class' => 'date-time-picker'
         ],
         'pluginOptions' => [
            'autoclose' => true,
            'minuteStep' => 1,
            'position' => 'top',
            'todayHighlight' => true,
            'format' => 'dd-mm-yyyy hh:ii',
         ]
      ],
      ExportMenu::class => [
         'clearBuffers' => true,
         'target' => ExportMenu::TARGET_BLANK,
         'dropdownOptions' => [
            'icon' => '<i class="bi bi-download"></i>',
            'label' => 'Download',
            'class' => 'btn btn-outline-success'
         ],
         'columnSelectorOptions' => [
            'icon' => '<i class="bi bi-list-columns"></i>',
            'label' => 'Kolom'
         ],
      ],
      kartik\grid\ActionColumn::class => [
         'dropdown' => false,
         'mergeHeader' => false,
         'vAlign' => 'middle',
         'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
         },
         'contentOptions' => [
            'class' => 'text-nowrap'
         ],
         'viewOptions' => [
            'label' => '<i class="bi bi-eye-fill"></i>',
            'role' => 'modal-remote',
            'title' => 'View',
            'data-toggle' => 'tooltip'
         ],
         'updateOptions' => [
            'label' => '<i class="bi bi-pencil-fill"></i>',
            'role' => 'modal-remote',
            'title' => 'Update',
            'data-toggle' => 'tooltip'
         ],
         'deleteOptions' => [
            'label' => '<i class="bi bi-trash"></i>',
            'class' => 'text-danger',
            'role' => 'modal-remote',
            'title' => 'Delete',
            'data-confirm' => false,
            'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
         ],
      ]
   ]
];