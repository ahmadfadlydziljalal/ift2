<?php

namespace app\models;

use app\models\base\QuotationFormJob as BaseQuotationFormJob;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_form_job".
 */
class QuotationFormJob extends BaseQuotationFormJob
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/FJ/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],
            ]
        );
    }

    public function rules(): array
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

        $this->tanggal = Yii::$app->formatter->asDate($this->tanggal, "php:Y-m-d");
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        if (!empty($this->tanggal)) {
            $this->tanggal = Yii::$app->formatter->asDate($this->tanggal);
        }
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'id' => 'ID',
                'quotation_id' => 'Quotation',
                'nomor' => 'Nomor',
                'tanggal' => 'Tanggal',
                'person_in_charge' => 'Person In Charge',
                'issue' => 'Issue',
                'card_own_equipment_id' => 'Card Own Equipment',
                'hour_meter' => 'Hour Meter',
                'mekanik_id' => 'Mekanik',
            ]
        );
    }

}