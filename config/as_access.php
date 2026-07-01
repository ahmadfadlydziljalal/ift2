<?php

return [
    'class' => 'mdm\\admin\\components\\AccessControl',
    'allowActions' => [
        'site/*',
        'dark-light-toggle/*',
        // Allow ScanController to handle its own auth logic (Bearer for WebView, redirect for browsers)
        'scan/*',
    ]
];