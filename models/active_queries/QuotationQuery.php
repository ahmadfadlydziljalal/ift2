<?php

namespace app\models\active_queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Quotation]].
 *
 * @see \app\models\Quotation
 */
class QuotationQuery extends ActiveQuery {


    public function liveSearch(string $q) {
        return parent::select([
            'id'   => 'id',
            'text' => 'nomor',
        ])->where(['LIKE', 'nomor', $q])
            ->orderBy(['nomor' => SORT_DESC]);
    }

}