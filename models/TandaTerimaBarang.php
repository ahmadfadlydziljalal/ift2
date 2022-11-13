<?php

namespace app\models;

use app\enums\TandaTerimaStatusEnum;
use app\models\base\TandaTerimaBarang as BaseTandaTerimaBarang;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "tanda_terima_barang".
 * @property TandaTerimaBarangDetail[] $tandaTerimaBarangDetails
 * @property PurchaseOrder $purchaseOrder
 */
class TandaTerimaBarang extends BaseTandaTerimaBarang
{

    use NomorSuratTrait;

    const STATUS_TEMPORARY = 'status-temporary';
    const STATUS_FINAL = 'status-final';

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

    /**
     * @return string
     */
    public function getStatusInHtmlLabel(): string
    {
        return $this->getStatus()
            ? Html::tag('span', '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
</svg>' . ' ' . TandaTerimaStatusEnum::COMPLETED->value, [
                'class' => 'badge bg-primary'
            ])
            : Html::tag('span',
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
</svg>' . ' ' . TandaTerimaStatusEnum::NOT_COMPLETED->value, [
                    'class' => 'badge bg-danger'
                ]);
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        $statusMaterialRequestDetailPenawaransDenganTandaTerimaDetail = [];
        foreach ($this->materialRequisitionDetailPenawarans as $materialRequisitionDetailPenawaran) {
            $statusMaterialRequestDetailPenawaransDenganTandaTerimaDetail[] = $materialRequisitionDetailPenawaran->getStatusPenerimaan();
        }
        return !in_array(false, $statusMaterialRequestDetailPenawaransDenganTandaTerimaDetail);
    }


}