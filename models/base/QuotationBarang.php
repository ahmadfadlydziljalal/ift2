<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation_barang".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $barang_id
 * @property string $stock
 * @property string $quantity
 * @property integer $satuan_id
 * @property string $unit_price
 * @property integer $discount
 * @property integer $is_vat
 *
 * @property \app\models\Barang $barang
 * @property \app\models\Quotation $quotation
 * @property \app\models\QuotationDeliveryReceiptDetail[] $quotationDeliveryReceiptDetails
 * @property \app\models\Satuan $satuan
 * @property string $aliasModel
 */
abstract class QuotationBarang extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['quotation_id', 'barang_id', 'satuan_id', 'discount', 'is_vat'], 'integer'],
            [['barang_id', 'quantity', 'satuan_id'], 'required'],
            [['stock', 'quantity', 'unit_price'], 'number'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Barang::class, 'targetAttribute' => ['barang_id' => 'id']],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Quotation::class, 'targetAttribute' => ['quotation_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Satuan::class, 'targetAttribute' => ['satuan_id' => 'id']]
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
            'barang_id' => 'Barang ID',
            'stock' => 'Stock',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan ID',
            'unit_price' => 'Unit Price',
            'discount' => 'Discount',
            'is_vat' => 'Is Vat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(\app\models\Barang::class, ['id' => 'barang_id']);
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
    public function getQuotationDeliveryReceiptDetails()
    {
        return $this->hasMany(\app\models\QuotationDeliveryReceiptDetail::class, ['quotation_barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(\app\models\Satuan::class, ['id' => 'satuan_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\QuotationBarangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationBarangQuery(get_called_class());
    }


}
