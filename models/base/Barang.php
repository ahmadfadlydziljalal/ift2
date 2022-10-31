<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "barang".
 *
 * @property integer $id
 * @property integer $tipe_pembelian_id
 * @property string $nama
 * @property string $part_number
 * @property string $keterangan
 * @property string $ift_number
 * @property string $merk_part_number
 * @property integer $originalitas_id
 *
 * @property \app\models\BarangSatuan[] $barangSatuans
 * @property \app\models\ClaimPettyCashNotaDetail[] $claimPettyCashNotaDetails
 * @property \app\models\FakturDetail[] $fakturDetails
 * @property \app\models\MaterialRequisitionDetail[] $materialRequisitionDetails
 * @property \app\models\Originalitas $originalitas
 * @property \app\models\PurchaseOrderDetail[] $purchaseOrderDetails
 * @property \app\models\TipePembelian $tipePembelian
 * @property string $aliasModel
 */
abstract class Barang extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['tipe_pembelian_id', 'nama', 'originalitas_id'], 'required'],
            [['tipe_pembelian_id', 'originalitas_id'], 'integer'],
            [['keterangan'], 'string'],
            [['nama', 'merk_part_number'], 'string', 'max' => 255],
            [['part_number'], 'string', 'max' => 32],
            [['ift_number'], 'string', 'max' => 128],
            [['originalitas_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Originalitas::class, 'targetAttribute' => ['originalitas_id' => 'id']],
            [['tipe_pembelian_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\TipePembelian::class, 'targetAttribute' => ['tipe_pembelian_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipe_pembelian_id' => 'Tipe Pembelian ID',
            'nama' => 'Nama',
            'part_number' => 'Part Number',
            'keterangan' => 'Keterangan',
            'ift_number' => 'Ift Number',
            'merk_part_number' => 'Merk Part Number',
            'originalitas_id' => 'Originalitas ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangSatuans()
    {
        return $this->hasMany(\app\models\BarangSatuan::class, ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimPettyCashNotaDetails()
    {
        return $this->hasMany(\app\models\ClaimPettyCashNotaDetail::class, ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakturDetails()
    {
        return $this->hasMany(\app\models\FakturDetail::class, ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetails()
    {
        return $this->hasMany(\app\models\MaterialRequisitionDetail::class, ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOriginalitas()
    {
        return $this->hasOne(\app\models\Originalitas::class, ['id' => 'originalitas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(\app\models\PurchaseOrderDetail::class, ['barang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipePembelian()
    {
        return $this->hasOne(\app\models\TipePembelian::class, ['id' => 'tipe_pembelian_id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\BarangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\BarangQuery(get_called_class());
    }


}
