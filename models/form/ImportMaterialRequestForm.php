<?php

namespace app\models\form;

use app\models\Barang;
use app\models\Card;
use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Import sebuah excel untuk kita kelola menjadi Material Requisition
 *
 */
class ImportMaterialRequestForm extends Model {

    const SCENARIO_STEP_1 = 'first';
    const SCENARIO_STEP_2 = 'second';

    public string|UploadedFile|null $file = null;

    public ?string $toOrangKantor = null;
    public ?string $tanggal = null;
    public ?string $remarks = null;
    public ?string $approvedBy = null;
    public ?string $acknowledgeBy = null;
    public ?string $cacheKey = null;

    /** @var ImportMaterialRequestExcelFormRecord[] */
    public array $importMaterialRequestExcelRecord = [];

    /**
     * @inheritdoc
     */
    public function rules(): array {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv, xls, xlsx', 'on' => self::SCENARIO_STEP_1],
            [['toOrangKantor', 'tanggal', 'approvedBy', 'acknowledgeBy'], 'required', 'on' => self::SCENARIO_STEP_2],
            [['remarks'], 'safe', 'on' => self::SCENARIO_STEP_2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array {
        return [
            'file' => 'File Import',
        ];
    }

    /**
     * @return bool
     * @throws NotFoundHttpException
     */
    public function import(): bool {

        if (!$this->validate()) return false;

        // 1. Save file
        if ($this->saveFile()) {
            // 2. Read that file using PhpSpreadsheet
            $spreadsheet = $this->readFile();

            // 3. get active sheet to array, then create an array object for `ImportMaterialRequestExcelRecord`
            $this->importMaterialRequestExcelRecord = $this->createAnArrayObjectOfImportMaterialRequestExcelRecord($spreadsheet);
            return true;
        }
        return false;
    }

    /**
     * @return ImportMaterialRequestExcelFormRecord[]
     */
    public function getImportMaterialRequestExcelRecord(): array {
        return $this->importMaterialRequestExcelRecord;
    }

    /**
     * @param string $key
     */
    public function setImportMaterialRequestExcelRecord(string $key): void {
        $this->cacheKey = $key;
        if (empty($this->importMaterialRequestExcelRecord)) {
            $this->importMaterialRequestExcelRecord = Yii::$app->cache->get($this->cacheKey);
        }
    }

    /**
     * @return string|null
     */
    public function getCacheKey(): ?string {
        return $this->cacheKey;
    }

    /**
     * @return bool
     */
    private function saveFile(): bool {
        return $this->file->saveAs(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $this->file->baseName . '.' . $this->file->extension);
    }

    /**
     * @return Spreadsheet
     */
    private function readFile(): Spreadsheet {
        return IOFactory::load(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $this->file->baseName . '.' . $this->file->extension);
    }

    /**
     * Contoh data yang dikembalikan:
     * ```
     * [
     *      0 => app\models\form\ImportMaterialRequestExcelRecord#1
     *      (
     *          [nomor] => '1'
     *          [part_number] => '60000075'
     *          [description] => 'Radiator Assembly'
     *          [kode_vendor] => 'SANY'
     *          [quantity] => '3'
     *          [harga_per_item] => '16,007,000'
     *          [total_harga] => '48,021,000'
     *          [stock] => '0'
     *          [remark] => 'TRANS CONTINENT'
     *      )
     *      1 => app\models\form\ImportMaterialRequestExcelRecord#2
     *      (
     *          [nomor] => '2'
     *          [part_number] => '14181873'
     *          [description] => 'Sealing Kit'
     *          [kode_vendor] => 'SANY'
     *          [quantity] => '6'
     *          [harga_per_item] => '276,000'
     *          [total_harga] => '1,656,000'
     *          [stock] => '0'
     *          [remark] => 'SEACON LNJ'
     *      )
     * ]
     * ```
     * @param Spreadsheet $spreadsheet
     * @return ImportMaterialRequestExcelFormRecord[]
     * @throws NotFoundHttpException
     */
    private function createAnArrayObjectOfImportMaterialRequestExcelRecord(Spreadsheet $spreadsheet): array {

        $sheet = $spreadsheet->getActiveSheet()->toArray();
        // remove first element, karena dia adalah header/title dari excel
        array_shift($sheet);

        $partNumbers = Barang::find()->select([
            'id' => 'barang.id',
            'part_number',
            'default_satuan_id',
        ])->indexBy('part_number')->asArray()->all();
        $vendors = Card::find()->map(Card::GET_ONLY_VENDOR, from: 'kode', to: 'id');

        $data = [];
        foreach ($sheet as $row) {
            if (empty($row[0])) continue;
            $data[] = new ImportMaterialRequestExcelFormRecord([
                'nomor'          => $row[0],
                'part_number'    => $partNumbers[$row[1]]['id'] ?? NULL,
                'description'    => $row[2],
                'kode_vendor'    => $vendors[$row[3]] ?? NULL, // $row[3]
                'quantity'       => $row[4],
                'harga_per_item' => str_replace([',', '.'], '', ($row[5] ?? 0)), // convert to number
                'total_harga'    => str_replace([',', '.'], '', ($row[6] ?? 0)),
                'stock'          => $row[7],
                'remark'         => $row[8],
                'satuan_id'      => $partNumbers[$row[1]]['default_satuan_id'] ?? NULL,
            ]);
        }

        $this->cacheKey = 'import-material-request-excel-form-record-' . time();
        Yii::$app->cache->set($this->cacheKey, $data, 3600 * 24 * 1); // cache selama 1 hari
        return $data;
    }

    /**
     * @return bool
     */
    public function save(): bool {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new MaterialRequisition([
                'vendor_id'         => $this->toOrangKantor,
                'tanggal'           => $this->tanggal,
                'remarks'           => $this->remarks,
                'approved_by_id'    => $this->approvedBy,
                'acknowledge_by_id' => $this->acknowledgeBy,
            ]);

            $flag = $model->save(false);
            if ($flag) {
                foreach ($this->importMaterialRequestExcelRecord as $r) {
                    $detail = new MaterialRequisitionDetail([
                        'material_requisition_id' => $model->id,
                        'barang_id'               => $r->part_number,
                        'description'             => $r->remark,     // atau $r->description jika itu yang diinginkan
                        'quantity'                => $r->quantity,
                        'satuan_id'               => $r->satuan_id,
                    ]);

                    // $model->link('materialRequisitionDetails', $detail); # ini akan set 'material_requisition_id' otomatis berdasarkan relasi
                    $flag = $detail->save(false);
                    if (!$flag) break;

                    // juga simpan `material_requisition_detail_penawaran`
                    $detailPenawaran = new MaterialRequisitionDetailPenawaran([
                        'material_requisition_detail_id' => $detail->id,
                        'vendor_id'                      => $r->kode_vendor,
                        'mata_uang_id'                   => 1,
                        'quantity_pesan'                 => $r->quantity,
                        'harga_penawaran'                => $r->harga_per_item,
                    ]);

                    $flag = $detailPenawaran->save(false);
                    if (!$flag) break;

                }
            }

            if ($flag) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return false;
    }

}