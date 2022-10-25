<?php

return [
    'appVersion' => 'v0.0.0',
    'bsVersion' => '5.x',
    'adminEmail' => getenv('EMAIL_ADMIN'),
    'senderEmail' => getenv('EMAIL_SENDER'),
    'senderName' =>getenv('EMAIL_SENDER_NAME'),
    'companyName' => getenv('COMPANY_NAME'),
    'myOwnCompany' =>getenv('MY_OWN_COMPANY'),
    'theme' => !isset($_COOKIE['theme']) ? 'light' : $_COOKIE['theme'],
    'themeAttribute' => !isset($_COOKIE['themeAttribute']) ? 'bg-light text-dark' : urldecode($_COOKIE['themeAttribute']),
    'superAdminUserToken' => getenv('HRD_TOKEN_SUPER_ADMIN'),
    'hrdSystem' => getenv('HRD_SYSTEM'),
    'hrdUrl' => getenv('HRD_URL'),
    'sessionName' => getenv('SESSION_NAME'),
    'env' => getenv('ENV'),
    'maintainer' => getenv('MAINTAINER'),
];