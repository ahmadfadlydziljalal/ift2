<?php

namespace app\models\active_queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Quotation]].
 *
 * @see \app\models\Quotation
 */
class QuotationQuery extends ActiveQuery {


    public function liveSearch(string $q): QuotationQuery {
        return parent::select([
            'id'   => 'id',
            'text' => 'nomor',
        ])->where(['LIKE', 'nomor', $q])
            ->orderBy(['nomor' => SORT_DESC]);
    }

    public function attendanceList(int $id) {
        $query = parent::select([
            'attendant_1',
            'attendant_2',
        ])->where(['id' => $id])
            ->one();

        $data = [];
        if (!empty($query->attendant_1)) {
            $data[$query->attendant_1] = $query->attendant_1;
        }

        if (!empty($query->attendant_2)) {
            $data[$query->attendant_2] = $query->attendant_2;
        }


        return $data;
    }

}