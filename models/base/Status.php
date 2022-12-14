<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "status".
 *
 * @property integer $id
 * @property string $section
 * @property string $key
 * @property string $value
 * @property array $options
 *
 * @property \app\models\MaterialRequisitionDetailPenawaran[] $materialRequisitionDetailPenawarans
 * @property string $aliasModel
 */
abstract class Status extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['section', 'key', 'value'], 'required'],
            [['options'], 'safe'],
            [['section', 'key', 'value'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section' => 'Section',
            'key' => 'Key',
            'value' => 'Value',
            'options' => 'Options',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialRequisitionDetailPenawarans()
    {
        return $this->hasMany(\app\models\MaterialRequisitionDetailPenawaran::class, ['status_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\active_queries\StatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\active_queries\StatusQuery(get_called_class());
    }


}
