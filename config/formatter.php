<?php

return [
    'class' => 'app\components\MyFormatter',
    'defaultTimeZone' => 'Asia/Jakarta',
    'dateFormat' => 'php:d-m-Y',
    'datetimeFormat' => 'php:d-m-Y H:i',
    'timeFormat' => 'php:H:i',
    'thousandSeparator' => ",",
    'decimalSeparator' => '.',
    'currencyCode' => "Rp.",
    'numberFormatterOptions' => [
        NumberFormatter::MIN_FRACTION_DIGITS => 0,
        NumberFormatter::MAX_FRACTION_DIGITS => 2,
    ],
    'nullDisplay' => '',
    'locale' => 'id-ID', //your language locale
];