<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\enums\KategoriSatuanEnum;
use app\models\Satuan;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Satuan]].
 *
 * @see Satuan
 */
class SatuanQuery extends ActiveQuery {

    /**
     * @param int $kategori
     * @return array
     */
    public function map(int $kategori = 1, $from = 'id', $to = 'nama'): array {
        $data = parent::select([$from, $to]);

        if ($kategori != KategoriSatuanEnum::KEDUANYA->value) {
            $data->where(['kategori' => $kategori]);
        }

        return ArrayHelper::map($data->orderBy($to)->all(), $from, $to);
    }

    public function mapIdName() {
        return parent::select(['id' => 'id', 'name' => 'nama'])
            ->asArray()
            ->all();
    }

}