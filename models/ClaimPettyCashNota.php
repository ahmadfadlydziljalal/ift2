<?php

namespace app\models;

use app\models\base\ClaimPettyCashNota as BaseClaimPettyCashNota;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "claim_petty_cash_nota".
 */
class ClaimPettyCashNota extends BaseClaimPettyCashNota
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

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'id' => 'ID',
                'claim_petty_cash_id' => 'Claim Petty Cash',
                'nomor' => 'Nomor',
                'vendor_id' => 'Vendor',
            ]
        );
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->tanggal_nota =
            !empty($this->tanggal_nota) ?
                Yii::$app->formatter->asDate($this->tanggal_nota) :
                $this->tanggal_nota;
    }

    public function beforeSave($insert)
    {
        $this->tanggal_nota =
            !empty($this->tanggal_nota) ?
                Yii::$app->formatter->asDate($this->tanggal_nota, 'php:Y-m-d') :
                $this->tanggal_nota;
        return parent::beforeSave($insert);
    }
}