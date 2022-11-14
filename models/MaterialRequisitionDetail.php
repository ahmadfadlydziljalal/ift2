<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use app\models\base\MaterialRequisitionDetail as BaseMaterialRequisitionDetail;
use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "material_requisition_detail".
 * @property TandaTerimaBarangDetail[] $tandaTerimaBarangDetails
 * @property TandaTerimaBarang[] $tandaTerimaBarangs
 */
class MaterialRequisitionDetail extends BaseMaterialRequisitionDetail
{

    const SCENARIO_MR = 'mr';
    const SCENARIO_PO = 'po';
    const SCENARIO_PENAWARAN_VENDOR = 'penawaran-vendor';

    public ?string $barangId = null;
    public ?string $barangPartNumber = null;
    public ?string $barangIftNumber = null;
    public ?string $barangMerkPartNumber = null;
    public ?string $barangNama = null;
    public ?string $barangSatuanJson = null;
    public ?string $tipePembelian = null;
    public ?string $tipePembelianNama = null;
    public ?string $vendorNama = null;
    public ?string $satuanNama = null;
    public ?string $penawaranDariVendor = null;
    public ?array $arrayObjectPenawaran = null;


    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MR] = [
            'tipePembelian',
            'barang_id',
            'description',
            'quantity',
            'satuan_id',
        ];
        $scenarios[self::SCENARIO_PENAWARAN_VENDOR] = [
            'arrayObjectPenawaran'
        ];

        return $scenarios;
    }

    public function validatePenawaranList($attribute, $params, $validator)
    {

        $column = array_count_values(
            array_column(ArrayHelper::toArray($this->$attribute), 'vendor_id'
            )
        );

        if (empty($column)) {
            $this->addError($attribute, 'Tidak ditemukan array vendor');
        }

        $duplicate = false;
        foreach ($column as $value) {
            if ($value > 1) {
                $duplicate = true;
                break;
            }
        }

        if ($duplicate) {
            $this->addError($attribute, 'Terdapat vendor yang duplikat');
        }

    }

    public function rules(): array
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['tipePembelian', 'arrayObjectPenawaran'], 'safe'],
                [['arrayObjectPenawaran'], 'validatePenawaranList'],
                [['barang_id'], 'required', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return
                        in_array($model->tipePembelian, [
                            TipePembelianEnum::STOCK->value,
                            TipePembelianEnum::PERLENGKAPAN->value
                        ]);
                }, 'message' => 'Barang / Perlengkapan cannot be blank'],

                [['barang_id'], 'compare', 'compareValue' => '', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return !in_array($model->tipePembelian, [
                        TipePembelianEnum::STOCK->value,
                        TipePembelianEnum::PERLENGKAPAN->value
                    ]);
                }, 'message' => '{attribute} should be blank ...!'],

                [['description'], 'required', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
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
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'material_requisition_id' => 'Material Requisition',
            'barang_id' => 'Barang',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan',
            'waktu_permintaan_terakhir' => 'Last Req',
            'harga_terakhir' => 'Last Price',
            'stock_terakhir' => 'Last Stock',
        ]);
    }

    public function getSubtotal()
    {
        return $this->quantity * $this->harga_terakhir;
    }

    /**
     * @param array $modelsDetail
     * @param int $materialRequisitionDetailId
     * @return array
     */
    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function createPenawaran(array $modelsDetail, int $materialRequisitionDetailId): array
    {
        $transaction = MaterialRequisitionDetail::getDb()->beginTransaction();

        try {

            $flag = true;
            foreach ($modelsDetail as $detail) :

                /** @var MaterialRequisitionDetailPenawaran $detail */
                $detail->material_requisition_detail_id = $materialRequisitionDetailId;
                if (!($flag = $detail->save(false))) {
                    break;
                }
            endforeach;

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }

        } catch (Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;
    }

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function updatePenawaran(array $modelsDetail, int $materialRequisitionDetailId, array $deletedDetailsID): array
    {
        $transaction = MaterialRequisitionDetailPenawaran::getDb()->beginTransaction();

        try {

            $flag = true;

            if (!empty($deletedDetailsID)) {
                MaterialRequisitionDetailPenawaran::deleteAll(['id' => $deletedDetailsID]);
            }

            foreach ($modelsDetail as $detail) :

                /** @var MaterialRequisitionDetailPenawaran $detail */
                $detail->material_requisition_detail_id = $materialRequisitionDetailId;
                if (!($flag = $detail->save(false))) {
                    break;
                }
            endforeach;

            if ($flag) {
                $transaction->commit();
                $status = ['code' => 1, 'message' => 'Commit'];
            } else {
                $transaction->rollBack();
                $status = ['code' => 0, 'message' => 'Roll Back'];
            }

        } catch (Exception $e) {
            $transaction->rollBack();
            $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
        }

        return $status;
    }

    /**
     * @return ActiveQuery
     */
    public function getMaterialRequisitionDetailPenawarans()
    {
        return $this->hasMany(MaterialRequisitionDetailPenawaran::class, ['material_requisition_detail_id' => 'id']);
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
    public function getTandaTerimaBarangs(): ActiveQuery
    {
        return $this->hasMany(TandaTerimaBarang::class, ['id' => 'tanda_terima_barang_id'])
            ->via('tandaTerimaBarangDetails');
    }


}