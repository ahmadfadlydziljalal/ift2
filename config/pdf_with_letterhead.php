<?php

return [
   'class' => kartik\mpdf\Pdf::class,
   'format' => kartik\mpdf\Pdf::FORMAT_A4,
   'orientation' => kartik\mpdf\Pdf::ORIENT_PORTRAIT,
   'destination' => kartik\mpdf\Pdf::DEST_BROWSER,
   'cssFile' => '@app/themes/v2/dist/css/pdf-print.css',
   'methods' => [
      'SetDisplayMode' => 'fullpage',
      'SetDisplayPreferences' => '/HideMenubar/HideToolbar/DisplayDocTitle/FitWindow',
   ],
   'marginTop' => '26.5',
   'marginHeader' => '5',
   'marginRight' => '10',
   'options' => [
      'showWatermarkText' => true,
      'useSubstitutions' => false,
      //'simpleTables' => true,
   ],

];