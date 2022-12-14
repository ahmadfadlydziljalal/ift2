<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation_another_fee".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $type_another_fee_id
 * @property string $nominal
 *
 * @property \app\models\Quotation $quotation
 * @property \app\models\Status $typeAnotherFee
 * @property string $aliasModel
 */
abstract class QuotationAnotherFee extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_another_fee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quotation_id', 'type_another_fee_id'], 'integer'],
            [['type_another_fee_id'], 'required'],
            [['nominal'], 'number'],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Quotation::class, 'targetAttribute' => ['quotation_id' => 'id']],
            [['type_another_fee_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::class, 'targetAttribute' => ['type_another_fee_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'type_another_fee_id' => 'Type Another Fee ID',
            'nominal' => 'Nominal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotation()
    {
        return $this->hasOne(\app\models\Quotation::class, ['id' => 'quotation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAnotherFee()
    {
        return $this->hasOne(\app\models\Status::class, ['id' => 'type_another_fee_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\QuotationAnotherFeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationAnotherFeeQuery(get_called_class());
    }


}
