<?php

namespace app\models\form;

use yii\base\Model;

class BeforeCreateTandaTerimaBarangForm extends Model
{
    public ?string $nomorPurchaseOrder = null;

    public function rules(): array
    {
        return [
            ['nomorPurchaseOrder', 'required']
        ];
    }
}