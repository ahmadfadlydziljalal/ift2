<?php

namespace app\components;

use app\models\MataUang;
use yii\i18n\Formatter;

class MyFormatter extends Formatter
{
    public function asSpelloutSelainRupiah($value, $mataUangId): ?string
    {
        return ucwords(parent::asSpellout($value) . ' ' . MataUang::findOne($mataUangId)->nama);
    }

    public function asSpellout($value): ?string
    {
        return ucwords(parent::asSpellout($value)) . ' ' . MataUang::findOne(1)->nama;
    }
}