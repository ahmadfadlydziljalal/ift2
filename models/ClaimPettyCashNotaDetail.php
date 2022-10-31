<?php

namespace app\models;

use app\models\base\ClaimPettyCashNotaDetail as BaseClaimPettyCashNotaDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "claim_petty_cash_nota_detail".
 * @property string $approved_by [varchar(255)]
 * @property string $acknowledge_by [varchar(255)]
 * @property int $created_at [int]
 * @property int $updated_at [int]
 * @property string $created_by [varchar(10)]
 * @property string $updated_by [varchar(10)]
 */
class ClaimPettyCashNotaDetail extends BaseClaimPettyCashNotaDetail
{

    const TIPE_PEMBELIAN_STOCK = 1;

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules(): array
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['barang_id'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id == self::TIPE_PEMBELIAN_STOCK);
                }],

                [['barang_id'], 'compare', 'compareValue' => '', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id != self::TIPE_PEMBELIAN_STOCK);
                }, 'message' => '{attribute} must be should be blank ...!'],

                [['description'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id != self::TIPE_PEMBELIAN_STOCK);
                }],

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