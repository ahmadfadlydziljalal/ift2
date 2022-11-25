<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation_delivery_receipt".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property string $nomor
 * @property string $tanggal
 * @property string $purchase_order_number
 * @property string $checker
 * @property string $vehicle
 * @property string $remarks
 *
 * @property \app\models\Quotation $quotation
 * @property string $aliasModel
 */
abstract class QuotationDeliveryReceipt extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_delivery_receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quotation_id'], 'integer'],
            [['tanggal'], 'required'],
            [['tanggal'], 'safe'],
            [['remarks'], 'string'],
            [['nomor', 'purchase_order_number', 'checker', 'vehicle'], 'string', 'max' => 255],
            [['quotation_id'], 'unique'],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Quotation::class, 'targetAttribute' => ['quotation_id' => 'id']]
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
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal',
            'purchase_order_number' => 'Purchase Order Number',
            'checker' => 'Checker',
            'vehicle' => 'Vehicle',
            'remarks' => 'Remarks',
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
     * @inheritdoc
     * @return \app\models\active_queries\QuotationDeliveryReceiptQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationDeliveryReceiptQuery(get_called_class());
    }


}