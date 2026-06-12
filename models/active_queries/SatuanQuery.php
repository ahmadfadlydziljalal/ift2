<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\enums\KategoriSatuanEnum;
use app\enums\QuotationFormJobJobsTypeEnum;
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
        $data = parent::select('id,nama')
            ->where(['kategori' => $kategori])
            ->orderBy(['nama' => SORT_ASC]);
        return ArrayHelper::map($data->all(), 'id', 'nama');
    }

    public function mapIdName() {
        return parent::select(['id' => 'id', 'name' => 'nama'])
            ->asArray()
            ->all();
    }

    public function forFormJob(int $type): array {
        if ($type == QuotationFormJobJobsTypeEnum::JOB->value) {
            return static::map(KategoriSatuanEnum::JASA->value);
        }

        if ($type == QuotationFormJobJobsTypeEnum::SPARE_PART->value) {
            return static::map(KategoriSatuanEnum::BARANG->value);
        }

        return [];

    }

}