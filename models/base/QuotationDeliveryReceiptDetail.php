<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation_delivery_receipt_detail".
 *
 * @property integer $id
 * @property integer $quotation_barang_id
 * @property integer $quotation_delivery_receipt_id
 * @property string $quantity
 * @property string $quantity_indent
 *
 * @property \app\models\HistoryLokasiBarang[] $historyLokasiBarangs
 * @property \app\models\QuotationBarang $quotationBarang
 * @property \app\models\QuotationDeliveryReceipt $quotationDeliveryReceipt
 * @property string $aliasModel
 */
abstract class QuotationDeliveryReceiptDetail extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_delivery_receipt_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quotation_barang_id', 'quantity'], 'required'],
            [['quotation_barang_id', 'quotation_delivery_receipt_id'], 'integer'],
            [['quantity', 'quantity_indent'], 'number'],
            [['quotation_barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\QuotationBarang::class, 'targetAttribute' => ['quotation_barang_id' => 'id']],
            [['quotation_delivery_receipt_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\QuotationDeliveryReceipt::class, 'targetAttribute' => ['quotation_delivery_receipt_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_barang_id' => 'Quotation Barang ID',
            'quotation_delivery_receipt_id' => 'Quotation Delivery Receipt ID',
            'quantity' => 'Quantity',
            'quantity_indent' => 'Quantity Indent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryLokasiBarangs()
    {
        return $this->hasMany(\app\models\HistoryLokasiBarang::class, ['quotation_delivery_receipt_detail_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationBarang()
    {
        return $this->hasOne(\app\models\QuotationBarang::class, ['id' => 'quotation_barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDeliveryReceipt()
    {
        return $this->hasOne(\app\models\QuotationDeliveryReceipt::class, ['id' => 'quotation_delivery_receipt_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\QuotationDeliveryReceiptDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationDeliveryReceiptDetailQuery(get_called_class());
    }


}
