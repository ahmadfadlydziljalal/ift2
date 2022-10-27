<?php

return [
    'class' => 'bilberrry\spaces\Service',
    'credentials' => [
        'key' => getenv('SPACES_DO_KEY'),
        'secret' => getenv('SPACES_DO_SECRET'),
    ],
    'region' => 'sgp1', // currently available: nyc3, ams3, sgp1, sfo2
    'defaultSpace' => 'files.tsurumaru.online',
    'defaultAcl' => 'public-read',
];