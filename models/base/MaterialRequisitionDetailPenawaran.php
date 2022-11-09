<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "material_requisition_detail_penawaran".
 *
 * @property integer $id
 * @property integer $material_requisition_detail_id
 * @property integer $vendor_id
 * @property string $harga_penawaran
 * @property integer $status_id
 * @property integer $purchase_order_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property \app\models\MaterialRequisitionDetail $materialRequisitionDetail
 * @property \app\models\PurchaseOrder $purchaseOrder
 * @property \app\models\Status $status
 * @property \app\models\Card $vendor
 * @property string $aliasModel
 */
abstract class MaterialRequisitionDetailPenawaran extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_requisition_detail_penawaran';
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
            [['material_requisition_detail_id', 'vendor_id', 'status_id', 'purchase_order_id'], 'integer'],
            [['vendor_id', 'harga_penawaran'], 'required'],
            [['harga_penawaran'], 'number'],
            [['material_requisition_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MaterialRequisitionDetail::class, 'targetAttribute' => ['material_requisition_detail_id' => 'id']],
            [['purchase_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\PurchaseOrder::class, 'targetAttribute' => ['purchase_order_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'material_requisition_detail_id' => 'Material Requisition Detail ID',
            'vendor_id' => 'Vendor ID',
            'harga_penawaran' => 'Harga Penawaran',
            'status_id' => 'Status ID',
            'purchase_order_id' => 'Purchase Order ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetail()
    {
        return $this->hasOne(\app\models\MaterialRequisitionDetail::class, ['id' => 'material_requisition_detail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(\app\models\PurchaseOrder::class, ['id' => 'purchase_order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(\app\models\Status::class, ['id' => 'status_id']);
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
     * @return \app\models\active_queries\MaterialRequisitionDetailPenawaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\MaterialRequisitionDetailPenawaranQuery(get_called_class());
    }


}