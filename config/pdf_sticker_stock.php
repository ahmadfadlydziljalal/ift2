<?php
$params = require __DIR__ . '/params.php';

return [
    'class'        => kartik\mpdf\Pdf::class,
    // custom paper size in mm
    'format'       => [50, 30],
//    'format'       => [80, 50],
    'orientation'  => kartik\mpdf\Pdf::ORIENT_PORTRAIT,
    'destination'  => kartik\mpdf\Pdf::DEST_BROWSER,
    'methods'      => [
        'SetDisplayMode'        => 'fullpage',
        'SetDisplayPreferences' => '/HideMenubar/HideToolbar/DisplayDocTitle/FitWindow',
    ],
    'marginTop'    => '2',
    'marginRight'  => '2',
    'marginBottom' => '2',
    'marginLeft'   => '2',
    'options'      => [
        'tableMinSizePriority' => false,
        'use_kwt'              => true,
        'showWatermarkText'    => true,
        'useSubstitutions'     => false,
        //'simpleTables' => true,
        // Tell mpdf to automatically map Chinese/Asian characters to an installed font
        'autoLangToFont'       => true,
        'autoScriptToLang'     => true,

    ],
];