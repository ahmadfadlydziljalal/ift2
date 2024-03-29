<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "card_own_equipment".
 *
 * @property integer $id
 * @property integer $card_id
 * @property string $nama
 * @property string $lokasi
 * @property string $tanggal_produk
 * @property string $serial_number
 *
 * @property \app\models\Card $card
 * @property \app\models\CardOwnEquipmentHistory[] $cardOwnEquipmentHistories
 * @property \app\models\QuotationFormJob[] $quotationFormJobs
 * @property string $aliasModel
 */
abstract class CardOwnEquipment extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card_own_equipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['card_id', 'nama', 'lokasi', 'tanggal_produk', 'serial_number'], 'required'],
            [['card_id'], 'integer'],
            [['lokasi'], 'string'],
            [['tanggal_produk'], 'safe'],
            [['nama', 'serial_number'], 'string', 'max' => 255],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Card::class, 'targetAttribute' => ['card_id' => 'id']]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'nama' => 'Nama',
            'lokasi' => 'Lokasi',
            'tanggal_produk' => 'Tanggal Produk',
            'serial_number' => 'Serial Number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'nama' => 'Equipment\'s name',
            'lokasi' => 'Equipment\'s location',
            'tanggal_produk' => 'Date of Product',
            'serial_number' => 'SN',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(\app\models\Card::class, ['id' => 'card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardOwnEquipmentHistories()
    {
        return $this->hasMany(\app\models\CardOwnEquipmentHistory::class, ['card_own_equipment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationFormJobs()
    {
        return $this->hasMany(\app\models\QuotationFormJob::class, ['card_own_equipment_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\CardOwnEquipmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\CardOwnEquipmentQuery(get_called_class());
    }


}
