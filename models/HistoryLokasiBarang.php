<?php

namespace app\models;

use Yii;
use \app\models\base\HistoryLokasiBarang as BaseHistoryLokasiBarang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "history_lokasi_barang".
 */
class HistoryLokasiBarang extends BaseHistoryLokasiBarang
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
