<?php
$params = require __DIR__ . '/params.php';

return [
    'class' => kartik\mpdf\Pdf::class,
    'format' => kartik\mpdf\Pdf::FORMAT_A4,
    'orientation' => kartik\mpdf\Pdf::ORIENT_PORTRAIT,
    'destination' => kartik\mpdf\Pdf::DEST_BROWSER,
    'cssFile' => '@app/themes/v2/dist/css/print.css',
    'methods' => [],
    'options' => [
        'showWatermarkText' => true,
        'useSubstitutions' => false,
        //'simpleTables' => true,
    ]
];