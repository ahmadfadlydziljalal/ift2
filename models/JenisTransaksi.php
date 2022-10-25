<?php

namespace app\models;

use Yii;
use \app\models\base\JenisTransaksi as BaseJenisTransaksi;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "jenis_transaksi".
 */
class JenisTransaksi extends BaseJenisTransaksi
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
