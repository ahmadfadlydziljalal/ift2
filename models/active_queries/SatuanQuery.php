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
    public function map(int $kategori = 1): array {
        $data = parent::select('id,nama');

        if ($kategori != KategoriSatuanEnum::KEDUANYA) {
            $data->where(['kategori' => $kategori])
                ->orderBy(['nama' => SORT_ASC]);
        }

        return ArrayHelper::map($data->all(), 'id', 'nama');
    }

    public function mapIdName() {
        return parent::select(['id' => 'id', 'name' => 'nama'])
            ->asArray()
            ->all();
    }

}