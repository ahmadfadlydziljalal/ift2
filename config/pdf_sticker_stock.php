<?php
$params = require __DIR__ . '/params.php';

return [
    'class'        => kartik\mpdf\Pdf::class,
    // custom paper size in mm
    'format'       => [60, 80],
//    'format'       => [80, 50],
    'orientation'  => kartik\mpdf\Pdf::ORIENT_LANDSCAPE,
    'destination'  => kartik\mpdf\Pdf::DEST_BROWSER,
    'methods'      => [
        'SetDisplayMode'        => 'fullpage',
        'SetDisplayPreferences' => '/HideMenubar/HideToolbar/DisplayDocTitle/FitWindow',
    ],
    'marginTop'    => '4',
    'marginRight'  => '4',
    'marginBottom' => '4',
    'marginLeft'   => '4',
    'marginHeader' => '0',
    'marginFooter' => '0',
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