<?php

namespace app\models;

use app\models\base\ClaimPettyCash as BaseClaimPettyCash;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "claim_petty_cash".
 */
class ClaimPettyCash extends BaseClaimPettyCash
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [

                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/CPC/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [

            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'id' => 'ID',
                'nomor' => 'Nomor',
                'vendor_id' => 'Vendor',
                'tanggal' => 'Tanggal',
                'remarks' => 'Remarks',
                'approved_by' => 'Approved By',
                'acknowledge_by' => 'Acknowledge By',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'created_by' => 'Created By',
                'updated_by' => 'Updated By',
            ]
        );
    }


    public function getClaimPettyCashNotaDetails()
    {
        return $this->hasMany(ClaimPettyCashNotaDetail::class, ['claim_petty_cash_nota_id' => 'id'])
            ->via('claimPettyCashNotas');
    }

    public function getTotalClaim(): float
    {
        $parent = $this->hasMany(ClaimPettyCashNotaDetail::class, ['claim_petty_cash_nota_id' => 'id'])
            ->via('claimPettyCashNotas');
        return round($parent->sum('quantity * harga'), 2);
    }

    public function getNomorDisplay(): string
    {
        $nomor = explode('/', $this->nomor);
        return $nomor[0] . '-' . ($nomor[count($nomor) - 2]) . '-' . end($nomor);
    }

}