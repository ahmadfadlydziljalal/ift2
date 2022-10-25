<?php

namespace app\components;

use yii\i18n\Formatter;

class MyFormatter extends Formatter
{
    public function asSpellout($value): ?string
    {
        $valueParent = ucwords(parent::asSpellout($value));
        return $valueParent . ' Rupiah';
    }
}