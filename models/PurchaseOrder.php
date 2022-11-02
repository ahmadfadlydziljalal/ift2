<?php

namespace app\models;

use app\components\helpers\SaveCacheKaryawan;
use app\models\base\PurchaseOrder as BasePurchaseOrder;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\httpclient\Exception;

/**
 * This is the model class for table "purchase_order".
 * @property $userKaryawan array
 * @property $usernameWhoCreated string
 */
class PurchaseOrder extends BasePurchaseOrder
{


    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [

                # custom behaviors,
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/PRC/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],

            ]
        );
    }

    public function rules(): array
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
            parent::attributeLabels(), [
                'vendor_id' => 'Vendor',
            ]
        );
    }

    public function getSumSubTotal(): float|int
    {
        $details = $this->materialRequisitionDetails;
        $total = 0;
        foreach ($details as $detail) {
            $total += $detail->quantity * $detail->harga_terakhir;
        }
        return $total;
    }

    public function getUsernameWhoCreated(): string
    {
        $user = User::findOne($this->created_by);
        return isset($user) ? $user->username : '';
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getUserKaryawan(): mixed
    {
        $cache = Yii::$app->cache;
        $dataKaryawan = $cache->get('sihrd-karyawan' . $this->created_by);

        if (empty($dataKaryawan)) {
            SaveCacheKaryawan::saveCache(User::findOne($this->created_by));
        }
        return $cache->get('sihrd-karyawan' . $this->created_by);
    }

}