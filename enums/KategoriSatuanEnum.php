<?php

namespace app\enums;

use yii\helpers\Inflector;

enum KategoriSatuanEnum: int
{
    case BARANG = 1;
    case JASA = 2;
    case KEDUANYA = 3;

    /**
     * @return array
     */
    public static function map(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = Inflector::humanize($case->name);
        }
        return $result;
    }


}
