<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "purchase_order".
 *
 * @property integer $id
 * @property string $nomor
 * @property integer $vendor_id
 * @property string $tanggal
 * @property string $reference_number
 * @property string $remarks
 * @property string $approved_by
 * @property string $acknowledge_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property \app\models\PurchaseOrderDetail[] $purchaseOrderDetails
 * @property \app\models\Card $vendor
 * @property string $aliasModel
 */
abstract class PurchaseOrder extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['vendor_id', 'tanggal', 'approved_by', 'acknowledge_by'], 'required'],
            [['vendor_id'], 'integer'],
            [['tanggal'], 'safe'],
            [['remarks'], 'string'],
            [['nomor'], 'string', 'max' => 128],
            [['reference_number', 'approved_by', 'acknowledge_by'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['vendor_id' => 'id']]
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
            'vendor_id' => 'Vendor ID',
            'tanggal' => 'Tanggal',
            'reference_number' => 'Reference Number',
            'remarks' => 'Remarks',
            'approved_by' => 'Approved By',
            'acknowledge_by' => 'Acknowledge By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::class, ['purchase_order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'vendor_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\PurchaseOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\PurchaseOrderQuery(get_called_class());
    }


}
