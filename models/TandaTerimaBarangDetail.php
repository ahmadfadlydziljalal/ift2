<?php

namespace app\models;

use app\models\base\TandaTerimaBarangDetail as BaseTandaTerimaBarangDetail;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tanda_terima_barang_detail".
 */
class TandaTerimaBarangDetail extends BaseTandaTerimaBarangDetail
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

    public function beforeSave($insert): bool
    {
        $this->tanggal = !empty($this->tanggal) ? Yii::$app->formatter->asDate($this->tanggal, 'php:Y-m-d') : null;
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->tanggal = Yii::$app->formatter->asDate($this->tanggal);
    }
}