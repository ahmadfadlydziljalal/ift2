<?php

namespace app\models;

use app\components\helpers\SaveCacheKaryawan;
use app\models\base\PurchaseOrder as BasePurchaseOrder;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\httpclient\Exception;

/**
 * This is the model class for table "purchase_order".
 * @property $userKaryawan array
 * @property $usernameWhoCreated string
 * @property TandaTerimaBarang $tandaTerimaBarang
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
                'approved_by_id' => 'Approved By',
                'acknowledge_by_id' => 'Acknowledge By',
            ]
        );
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

    /**
     * @return ActiveQuery
     */
    public function getTandaTerimaBarang()
    {
        return $this->hasOne(TandaTerimaBarang::class, ['id' => 'tanda_terima_barang_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Card::class, ['id' => 'vendor_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getMaterialRequisitionDetail(): ActiveQuery
    {
        return $this->hasOne(MaterialRequisitionDetail::class, ['id' => 'material_requisition_detail_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getMaterialRequisition(): ActiveQuery
    {
        return $this->hasOne(MaterialRequisition::class, ['id' => 'material_requisition_id'])
            ->via('materialRequisitionDetail');
    }


    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function createWithDetails(array $modelsDetail): array
    {

        $transaction = PurchaseOrder::getDb()->beginTransaction();

        try {

            if ($flag = $this->save(false)) {
                foreach ($modelsDetail as $detail) :
                    $detail->purchase_order_id = $this->id;
                    if (!($flag = $detail->save(false))) {
                        break;
                    }
                endforeach;
            }

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }

        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;

    }

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function updateWithDetails(array $modelsDetail, array $deletedDetailsID): array
    {
        $transaction = PurchaseOrder::getDb()->beginTransaction();
        try {
            if ($flag = $this->save(false)) {

                if (!empty($deletedDetailsID)) {
                    MaterialRequisitionDetail::updateAll(['purchase_order_id' => null], ['id' => $deletedDetailsID]);
                }

                foreach ($modelsDetail as $detail) :
                    $detail->purchase_order_id = $this->id;
                    if (!($flag = $detail->save(false))) {
                        break;
                    }
                endforeach;
            }

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }
        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;
    }

    public function getSumSubtotal(): float|int
    {
        return array_sum(
            array_map(function ($el) {
                return $el->quantity_pesan * $el->harga_penawaran;
            }, $this->materialRequisitionDetailPenawarans)
        );
    }

}