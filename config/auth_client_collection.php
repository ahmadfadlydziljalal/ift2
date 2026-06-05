<?php

return [
    'class'   => 'yii\authclient\Collection',
    'clients' => [
        'sihrd' => [
            'class'        => '\app\components\SihrdAuthClient',
            'clientId'     => getenv('HRD_CLIENT_ID'),             # Masukkan CLIENT_ID disini
            'clientSecret' => getenv('HRD_CLIENT_SECRET'),     # Masukkan CLIENT_SECRET disini
            'authUrl'      => getenv('HRD_AUTH_URL'),
            'tokenUrl'     => getenv('HRD_TOKEN_URL'),
            'apiBaseUrl'   => getenv('HRD_API_BASE_URL'),
            'apiUserInfo'  => getenv('HRD_API_USER_INFO'),
            'viewOptions'  => [
                'icon' => 'https://cdn-icons-png.flaticon.com/512/2376/2376399.png'
            ]
        ],
    ],
];
