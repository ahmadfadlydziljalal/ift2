<?php

return [
    'admin' => [
        'class' => 'mdm\admin\Module',
        'viewPath' => '@app/views/mdm',
        'defaultRoute' => '/admin/default',
    ],
    'datecontrol' => [
        'class' => 'kartik\datecontrol\Module',
        'displaySettings' => [
            kartik\datecontrol\Module::FORMAT_DATE => 'php:d-m-Y',
            kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i',
            kartik\datecontrol\Module::FORMAT_DATETIME => 'php:d-m-Y H:i',
        ],
        'saveSettings' => [
            kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d',
            kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
            kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
        ],
        'autoWidget' => true,
        'autoWidgetSettings' => [
            kartik\datecontrol\Module::FORMAT_DATE => [
                'type' => 1,
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'zIndexOffset' => 10000
                ],
            ],
            kartik\datecontrol\Module::FORMAT_DATETIME => [
                'type' => 1,
                'options' => [
                    'class' => 'date-time-picker'
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'minuteStep' => 1,
                    'position' => 'bottom',
                    'todayHighlight' => true,
                ]
            ],
            kartik\datecontrol\Module::FORMAT_TIME => [
                'pluginOptions' => [
                    'minuteStep' => 1,
                ],
                'value' => null
            ],
        ],
        'widgetSettings' => [
            kartik\datecontrol\Module::FORMAT_DATE => [
                'class' => 'yii\jui\DatePicker',
                'options' => [
                    'options' => ['class' => 'form-control picker'],
                ]
            ],
        ]
    ],
    'settings' => [
        'class' => 'pheme\settings\Module',
        'sourceLanguage' => 'en',
        'viewPath' => '@app/views/settings',
    ],
    'gridview' => [
        'class' => 'kartik\grid\Module',
    ],
    'gridviewPrint' => [
        'class' => 'kartik\grid\Module',
        'layout' => '{items}',
    ],
];