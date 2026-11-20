<?php

namespace app\models\form;

use app\enums\TipePembelianEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\Barang;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Form untuk menetapkan stock awal (start) sebuah barang yang tersebar di banyak lokasi.
 */
class BarangStart extends Model
{
    public $barangId;
    public $initializeStockQuantity;

    /** @var BarangStartLokasi[] */
    public array $lokasi = [];

    /** @var HistoryLokasiBarang[] */
    public array $savedHistories = [];

    public bool $isRestart = false;

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (empty($this->lokasi)) {
            $this->lokasi = [new BarangStartLokasi()];
        }
    }

    public function rules(): array
    {
        return [
            [['barangId', 'initializeStockQuantity'], 'required'],
            ['barangId', 'integer'],
            ['barangId', 'validateBarang'],
            ['initializeStockQuantity', 'number', 'min' => 0.01],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'barangId'                => 'Barang',
            'initializeStockQuantity' => 'Initialize Stock Quantity',
        ];
    }

    public function validateBarang(string $attribute): void
    {
        $barang = Barang::findOne($this->barangId);
        if (!$barang) {
            $this->addError($attribute, 'Barang tidak ditemukan.');
        } elseif ($barang->tipe_pembelian_id != TipePembelianEnum::STOCK->value) {
            $this->addError($attribute, 'Hanya barang bertipe stock yang dapat di-start.');
        } elseif (!$this->isRestart && $this->getStartHistories($barang->id)) {
            $this->addError($attribute, 'Barang ini sudah pernah di-start. Gunakan Restart untuk mengubahnya.');
        } elseif ($this->isRestart && !$this->getStartHistories($barang->id)) {
            $this->addError($attribute, 'Barang ini belum pernah di-start.');
        }
    }

    /**
     * Isi form dari data start yang sudah ada.
     */
    public function loadExisting(Barang $barang): void
    {
        $this->isRestart = true;
        $this->barangId = $barang->id;
        $this->initializeStockQuantity = (float)$barang->initialize_stock_quantity ?: null;
        $this->lokasi = [];
        foreach ($this->getStartHistories($barang->id) as $history) {
            $this->lokasi[] = new BarangStartLokasi([
                'quantity' => (float)$history->quantity,
                'cardId'   => $history->card_id,
                'block'    => $history->block,
                'rak'      => $history->rak,
                'tier'     => $history->tier,
                'row'      => $history->row,
                'catatan'  => $history->catatan,
            ]);
        }
        if (empty($this->lokasi)) {
            $this->lokasi = [new BarangStartLokasi()];
        }
    }

    public function isStarted(int $barangId): bool
    {
        return !empty($this->getStartHistories($barangId));
    }

    public function loadAll(array $post): bool
    {
        $loaded = $this->load($post);
        $rows = $post[(new BarangStartLokasi())->formName()] ?? [];
        if (is_array($rows) && $rows) {
            $this->lokasi = [];
            foreach ($rows as $row) {
                $model = new BarangStartLokasi();
                $model->setAttributes($row);
                $this->lokasi[] = $model;
            }
        }
        return $loaded;
    }

    public function validateAll(): bool
    {
        $valid = $this->validate();
        foreach ($this->lokasi as $model) {
            $valid = $model->validate() && $valid;
        }

        if ($valid) {
            $total = array_sum(array_map(static fn($m) => (float)$m->quantity, $this->lokasi));
            if (abs($total - (float)$this->initializeStockQuantity) > 0.0001) {
                $this->addError(
                    'initializeStockQuantity',
                    "Total quantity lokasi ($total) harus sama dengan Initialize Stock Quantity."
                );
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * @throws Throwable
     */
    public function save(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $barang = Barang::findOne($this->barangId);
            $barang->updateAttributes(['initialize_stock_quantity' => $this->initializeStockQuantity]);

            $statusId = $this->getStartStatusId();
            $this->savedHistories = [];
            $existing = $this->isRestart ? $this->getStartHistories($barang->id) : [];

            // Record lama yang tidak terpakai lagi dihapus; record yang direferensi transfer tidak boleh dihapus
            foreach (array_slice($existing, count($this->lokasi)) as $obsolete) {
                if (HistoryLokasiBarang::find()->where(['depend_id' => $obsolete->id])->exists()) {
                    throw new \RuntimeException('Lokasi ' . $obsolete->nomor . ' sudah dipakai oleh transaksi lain sehingga tidak dapat dihapus.');
                }
                $obsolete->delete();
            }

            foreach ($this->lokasi as $i => $row) {
                $history = $existing[$i] ?? new HistoryLokasiBarang([
                    'tipe_pergerakan_id' => $statusId,
                    'nomor'              => HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM->value),
                    'step'               => 0,
                    'barang_id'          => $barang->id,
                ]);
                $history->setAttributes([
                    'card_id'  => $row->cardId,
                    'quantity' => $row->quantity,
                    'block'    => $row->block,
                    'rak'      => $row->rak,
                    'tier'     => $row->tier,
                    'row'      => $row->row,
                    'catatan'  => $row->catatan,
                ], false);
                if (!$history->save()) {
                    throw new \RuntimeException('Gagal menyimpan lokasi: ' . json_encode($history->errors));
                }
                $this->savedHistories[] = $history;
            }

            $transaction->commit();
            return true;
        } catch (Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            $this->addError('barangId', 'Gagal menyimpan: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @return HistoryLokasiBarang[]
     */
    private function getStartHistories(int $barangId): array
    {
        $statusId = $this->getStartStatusId();
        if (!$statusId) {
            return [];
        }
        return HistoryLokasiBarang::find()
            ->where(['barang_id' => $barangId, 'tipe_pergerakan_id' => $statusId])
            ->orderBy('id')
            ->all();
    }

    private function getStartStatusId(): ?int
    {
        return Status::findOne([
            'section' => Status::SECTION_SET_LOKASI_BARANG,
            'key'     => 'start-pertama-kali-penerapan-sistem',
        ])?->id;
    }
}
