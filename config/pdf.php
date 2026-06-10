<?php
$params = require __DIR__ . '/params.php';

return [
    'class'       => kartik\mpdf\Pdf::class,
    'format'      => kartik\mpdf\Pdf::FORMAT_A4,
    'orientation' => kartik\mpdf\Pdf::ORIENT_PORTRAIT,
    'destination' => kartik\mpdf\Pdf::DEST_BROWSER,
    'cssFile'     => '@app/themes/v2/dist/css/pdf-print.css',
    'mode'        => kartik\mpdf\Pdf::MODE_UTF8,
    'methods'     => [],
    'options'     => [
        'showWatermarkText' => true,
        'useSubstitutions'  => false,
        //'simpleTables' => true,
        // Tell mpdf to automatically map Chinese/Asian characters to an installed font
        'autoLangToFont'    => true,
        'autoScriptToLang'  => true,
    ],


];