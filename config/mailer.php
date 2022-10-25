<?php

use yii\symfonymailer\Mailer;

return [
    'class' => Mailer::class,
    'viewPath' => '@app/mail',
    // send all mails to a file by default.
    'useFileTransport' => true,
];