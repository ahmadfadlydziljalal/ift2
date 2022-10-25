<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [

        'admin' => 'admin/default/index',
        'admin/user/create' => 'user/create',
        'admin/user/update' => 'user/update',
        'admin/user/create-with-sihrd-integration' => 'user/create-with-sihrd-integration',
        'admin/user/update-with-sihrd-integration' => 'user/update-with-sihrd-integration',

        '<action>' => 'site/<action>',
        '<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
        '<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
        '<controller:[\w\-]+>/<action:[\w\-]+' => '<controller>/<action>',

    ],
];