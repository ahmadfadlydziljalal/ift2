<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "tanda_terima_barang_detail".
 *
 * @property integer $id
 * @property integer $material_requisition_detail_penawaran_id
 * @property string $tanggal
 * @property string $quantity_terima
 *
 * @property \app\models\MaterialRequisitionDetailPenawaran $materialRequisitionDetailPenawaran
 * @property string $aliasModel
 */
abstract class TandaTerimaBarangDetail extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tanda_terima_barang_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['material_requisition_detail_penawaran_id'], 'integer'],
            [['tanggal', 'quantity_terima'], 'required'],
            [['tanggal'], 'safe'],
            [['quantity_terima'], 'number'],
            [['material_requisition_detail_penawaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MaterialRequisitionDetailPenawaran::class, 'targetAttribute' => ['material_requisition_detail_penawaran_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_requisition_detail_penawaran_id' => 'Material Requisition Detail Penawaran ID',
            'tanggal' => 'Tanggal',
            'quantity_terima' => 'Quantity Terima',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetailPenawaran()
    {
        return $this->hasOne(\app\models\MaterialRequisitionDetailPenawaran::class, ['id' => 'material_requisition_detail_penawaran_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\TandaTerimaBarangDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\TandaTerimaBarangDetailQuery(get_called_class());
    }


}
