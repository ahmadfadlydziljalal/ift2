<?php

namespace app\models;

use app\models\base\TandaTerimaBarang as BaseTandaTerimaBarang;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tanda_terima_barang".
 * @property TandaTerimaBarangDetail[] $tandaTerimaBarangDetails
 * @property PurchaseOrder $purchaseOrder
 */
class TandaTerimaBarang extends BaseTandaTerimaBarang
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/TRM-BRG/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
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
                # custom validation rules
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getTandaTerimaBarangDetails(): ActiveQuery
    {
        return $this->hasMany(TandaTerimaBarangDetail::class, ['material_requisition_detail_penawaran_id' => 'id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    /**
     * @return ActiveQuery
     */
    public function getPurchaseOrder(): ActiveQuery
    {
        return $this->hasOne(PurchaseOrder::class, ['id' => 'purchase_order_id'])
            ->via('materialRequisitionDetailPenawarans');
    }

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function deleteWithTandaTerimaBarangDetails(): array
    {
        $transaction = self::getDb()->beginTransaction();
        try {

            $flag = true;
            foreach ($this->tandaTerimaBarangDetails as $tandaTerimaBarangDetail) :
                if (!($flag = $tandaTerimaBarangDetail->delete())) {
                    break;
                }
            endforeach;

            if ($flag) $flag = $this->delete();

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Berhasil di hapus dan commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back'];
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back ' . $e->getMessage(),];
        } catch (Throwable $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Gagal menghapus data, Roll Back ' . $e->getMessage(),];
        }
        return $status;
    }
}