<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "proforma_debit_note_detail_service".
 *
 * @property integer $id
 * @property integer $proforma_debit_note_id
 * @property string $job_description
 * @property string $hours
 * @property string $rate_per_hour
 * @property integer $discount
 * @property integer $is_vat
 *
 * @property \app\models\ProformaDebitNote $proformaDebitNote
 * @property string $aliasModel
 */
abstract class ProformaDebitNoteDetailService extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proforma_debit_note_detail_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['proforma_debit_note_id', 'discount', 'is_vat'], 'integer'],
            [['job_description'], 'required'],
            [['hours', 'rate_per_hour'], 'number'],
            [['job_description'], 'string', 'max' => 255],
            [['proforma_debit_note_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\ProformaDebitNote::class, 'targetAttribute' => ['proforma_debit_note_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proforma_debit_note_id' => 'Proforma Debit Note ID',
            'job_description' => 'Job Description',
            'hours' => 'Hours',
            'rate_per_hour' => 'Rate Per Hour',
            'discount' => 'Discount',
            'is_vat' => 'Is Vat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProformaDebitNote()
    {
        return $this->hasOne(\app\models\ProformaDebitNote::class, ['id' => 'proforma_debit_note_id']);
    }




}