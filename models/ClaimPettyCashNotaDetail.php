<?php

namespace app\models;

use app\models\base\ClaimPettyCashNotaDetail as BaseClaimPettyCashNotaDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "claim_petty_cash_nota_detail".
 */
class ClaimPettyCashNotaDetail extends BaseClaimPettyCashNotaDetail
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'id' => 'ID',
                'claim_petty_cash_nota_id' => 'Claim Petty Cash Not',
                'tipe_pembelian_id' => 'Tipe Pembelian',
                'barang_id' => 'Barang',
                'description' => 'Description',
                'quantity' => 'Quantity',
                'satuan_id' => 'Satuan',
                'harga' => 'Harga',
            ]
        );
    }

    public function getSubTotal(): float|int
    {
        return $this->quantity * $this->harga;
    }
}