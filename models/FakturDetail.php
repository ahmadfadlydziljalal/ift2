<?php

namespace app\models;

use app\models\base\FakturDetail as BaseFakturDetail;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "faktur_detail".
 */
class FakturDetail extends BaseFakturDetail
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

            ]
        );
    }


    public function getFormatHargaBarangDiMediaCetak()
    {
        return [
            Yii::$app->getFormatter()->currencyCode,
            Yii::$app->formatter->asDecimal($this->harga_barang)
        ];
    }


    public function getSubTotal()
    {
        return $this->quantity * $this->harga_barang;
    }

    public function getFormatSubTotalDiMediaCetak(): array
    {
        return [
            Yii::$app->getFormatter()->currencyCode,
            Yii::$app->formatter->asDecimal($this->quantity * $this->harga_barang)
        ];
    }
    

}