<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "jenis_transaksi".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property \app\models\Faktur[] $fakturs
 * @property string $aliasModel
 */
abstract class JenisTransaksi extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jenis_transaksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakturs()
    {
        return $this->hasMany(\app\models\Faktur::class, ['jenis_transaksi_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\JenisTransaksiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\JenisTransaksiQuery(get_called_class());
    }


}
