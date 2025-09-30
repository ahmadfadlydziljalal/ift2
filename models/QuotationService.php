<?php

namespace app\models;

use app\models\base\QuotationService as BaseQuotationService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "quotation_service".
 * @property string $labelIsVat
 * @property float | int $nominalDiscount
 * @property float | int $rateAfterDiscount
 * @property float | int $amount
 * @property $amountBeforeDiscount float | int
 */
class QuotationService extends BaseQuotationService
{

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
                # custom validation rules
                ['discount', 'default', 'value' => 0],
                ['is_vat', 'default', 'value' => 1],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'is_vat' => 'Is Vat',
        ]);
    }

    /**
     * @return string
     */
    public function getLabelIsVat(): string
    {
        return empty($this->is_vat)
            ? Html::tag('span', 'NO V.A.T', ['class' => 'badge bg-secondary'])
            : Html::tag('span', 'V.A.T', ['class' => 'badge bg-info']);
    }

    /**
     * @return float|int
     */
    public function getNominalDiscount(): float|int
    {
        if ($this->discount) {
            return $this->rate * ($this->discount / 100);
        }

        return 0;
    }


    public function getRateAfterDiscount(): float
    {
        return ((float)$this->rate) - ((float)$this->nominalDiscount);
    }


    /**
     * @return float|int
     */
    public function getAmountBeforeDiscount(): float|int
    {
        return ($this->quantity * $this->rate);
    }

    /**
     * @return float|int
     */
    public function getAmount(): float|int
    {
        return ($this->quantity * $this->rateAfterDiscount);
    }

}