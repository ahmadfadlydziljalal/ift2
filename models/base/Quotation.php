<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "quotation".
 *
 * @property integer $id
 * @property string $nomor
 * @property integer $mata_uang_id
 * @property string $tanggal
 * @property integer $customer_id
 * @property string $tanggal_batas_valid
 * @property string $attendant_1
 * @property string $attendant_phone_1
 * @property string $attendant_email_1
 * @property string $attendant_2
 * @property string $attendant_phone_2
 * @property string $attendant_email_2
 * @property string $catatan_quotation_barang
 * @property string $catatan_quotation_service
 * @property string $delivery_fee
 * @property string $materai_fee
 * @property integer $vat_percentage
 * @property integer $rekening_id
 * @property integer $signature_orang_kantor_id
 *
 * @property \app\models\Card $customer
 * @property \app\models\MataUang $mataUang
 * @property \app\models\QuotationAnotherFee[] $quotationAnotherFees
 * @property \app\models\QuotationBarang[] $quotationBarangs
 * @property \app\models\QuotationDeliveryReceipt[] $quotationDeliveryReceipts
 * @property \app\models\QuotationFormJob $quotationFormJob
 * @property \app\models\QuotationService[] $quotationServices
 * @property \app\models\QuotationTermAndCondition[] $quotationTermAndConditions
 * @property \app\models\Rekening $rekening
 * @property \app\models\Card $signatureOrangKantor
 * @property string $aliasModel
 */
abstract class Quotation extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['mata_uang_id', 'tanggal', 'customer_id', 'tanggal_batas_valid', 'rekening_id', 'signature_orang_kantor_id'], 'required'],
            [['mata_uang_id', 'customer_id', 'vat_percentage', 'rekening_id', 'signature_orang_kantor_id'], 'integer'],
            [['tanggal', 'tanggal_batas_valid'], 'safe'],
            [['catatan_quotation_barang', 'catatan_quotation_service'], 'string'],
            [['delivery_fee', 'materai_fee'], 'number'],
            [['nomor'], 'string', 'max' => 128],
            [['attendant_1', 'attendant_phone_1', 'attendant_email_1', 'attendant_2', 'attendant_phone_2', 'attendant_email_2'], 'string', 'max' => 255],
            [['signature_orang_kantor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['signature_orang_kantor_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['mata_uang_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MataUang::class, 'targetAttribute' => ['mata_uang_id' => 'id']],
            [['rekening_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Rekening::class, 'targetAttribute' => ['rekening_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor' => 'Nomor',
            'mata_uang_id' => 'Mata Uang ID',
            'tanggal' => 'Tanggal',
            'customer_id' => 'Customer ID',
            'tanggal_batas_valid' => 'Tanggal Batas Valid',
            'attendant_1' => 'Attendant 1',
            'attendant_phone_1' => 'Attendant Phone 1',
            'attendant_email_1' => 'Attendant Email 1',
            'attendant_2' => 'Attendant 2',
            'attendant_phone_2' => 'Attendant Phone 2',
            'attendant_email_2' => 'Attendant Email 2',
            'catatan_quotation_barang' => 'Catatan Quotation Barang',
            'catatan_quotation_service' => 'Catatan Quotation Service',
            'delivery_fee' => 'Delivery Fee',
            'materai_fee' => 'Materai Fee',
            'vat_percentage' => 'Vat Percentage',
            'rekening_id' => 'Rekening ID',
            'signature_orang_kantor_id' => 'Signature Orang Kantor ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'mata_uang_id' => 'Mata uang yang akan digunakan',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMataUang()
    {
        return $this->hasOne(\app\models\MataUang::class, ['id' => 'mata_uang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationAnotherFees()
    {
        return $this->hasMany(\app\models\QuotationAnotherFee::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationBarangs()
    {
        return $this->hasMany(\app\models\QuotationBarang::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDeliveryReceipts()
    {
        return $this->hasMany(\app\models\QuotationDeliveryReceipt::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationFormJob()
    {
        return $this->hasOne(\app\models\QuotationFormJob::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationServices()
    {
        return $this->hasMany(\app\models\QuotationService::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationTermAndConditions()
    {
        return $this->hasMany(\app\models\QuotationTermAndCondition::class, ['quotation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekening()
    {
        return $this->hasOne(\app\models\Rekening::class, ['id' => 'rekening_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSignatureOrangKantor()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'signature_orang_kantor_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\QuotationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\QuotationQuery(get_called_class());
    }


}
