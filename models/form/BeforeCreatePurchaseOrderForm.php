<?php

namespace app\models\form;

use yii\base\Model;

class BeforeCreatePurchaseOrderForm extends Model
{
    public ?string $nomorMaterialRequest = null;

    public function rules(): array
    {
        return [
            ['nomorMaterialRequest', 'required']
        ];
    }
}