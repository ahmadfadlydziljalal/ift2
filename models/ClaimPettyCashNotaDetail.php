<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use app\models\base\ClaimPettyCashNotaDetail as BaseClaimPettyCashNotaDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

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

    public ?string $tipePembelian = null;

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
                ['tipePembelian', 'safe'],

                [['barang_id'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return
                        in_array($model->tipePembelian, [
                            TipePembelianEnum::STOCK->value,
                            TipePembelianEnum::PERLENGKAPAN->value
                        ]);
                }, 'message' => 'Barang / Perlengkapan cannot be blank'],

                [['barang_id'], 'compare', 'compareValue' => '', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return !in_array($model->tipePembelian, [
                        TipePembelianEnum::STOCK->value,
                        TipePembelianEnum::PERLENGKAPAN->value
                    ]);
                }, 'message' => '{attribute} should be blank ...!'],

                [['description'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return !in_array($model->tipePembelian, [
                        TipePembelianEnum::STOCK->value,
                        TipePembelianEnum::PERLENGKAPAN->value
                    ]);
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
                'tipePembelian' => 'Tipe Pembelian',
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

    public function getNamaTipePembelian(): string
    {
        
        /** @var ClaimPettyCashNotaDetail $model */
        return isset($this->barang)
            ? $this->barang->tipePembelian->nama
            : Inflector::camel2words(TipePembelianEnum::LAIN_LAIN->name);
    }
}