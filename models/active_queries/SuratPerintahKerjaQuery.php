<?php

namespace app\models\active_queries;

use app\models\SuratPerintahKerja;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[SuratPerintahKerja]].
 *
 * @see SuratPerintahKerja
 * @method SuratPerintahKerja[] all($db = null)
 * @method SuratPerintahKerja one($db = null)
 */
class SuratPerintahKerjaQuery extends ActiveQuery {

    public function liveSearch(string $q): SuratPerintahKerjaQuery {
        return parent::select([
            'id'   => 'id',
            'text' => 'nomor',
        ])->where(['LIKE', 'nomor', $q])
            ->orderBy(['nomor' => SORT_DESC]);
    }
}
