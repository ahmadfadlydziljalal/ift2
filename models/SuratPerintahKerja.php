<?php

namespace app\models;

use app\models\base\SuratPerintahKerja as BaseSuratPerintahKerja;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "surat_perintah_kerja".
 */
class SuratPerintahKerja extends BaseSuratPerintahKerja {

    public mixed $quotationPendukung = null;

    public function afterFind(): void {
        parent::afterFind();
        // Preload nilai untuk field Select2 (multiple) saat update form
        $this->quotationPendukung = SuratPerintahKerjaSupportingDocument::find()
            ->select('quotation_id')
            ->where(['surat_perintah_kerja_id' => $this->id])
            ->column();
    }

    public function rules(): array {
        return array_merge(BaseSuratPerintahKerja::rules(), [
            ['quotationPendukung', 'safe'],
        ]);
    }

    public function attributeHints(): array {
        return array_merge(BaseSuratPerintahKerja::attributeHints(), [
            'pelaksana'  => 'Dengan ini diberikan perintah kerja kepada',
            'judul'      => 'Untuk melaksanakan pekerjaan',
            'keterangan' => 'Detail Pekerjaan yang harus dilakukan, termasuk ruang lingkup pekerjaan, lokasi pekerjaan, dan lain-lain',
        ]);
    }

    public function behaviors(): array {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                [
                    'class'     => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value'     => '?' . '/IFTJKT/SPK/' . date('Y'), // format auto number. '?' will be replaced with generated number
                    'digit'     => 4,
                    'group'     => '/IFTJKT/SPK/' . date('Y')
                ],
            ]
        );
    }

    /**
     * Simpan data SuratPerintahKerja beserta relasi ke Quotation pendukung dalam satu transaksi
     * @return bool true jika berhasil, false jika gagal
     */
    public function saveWithQuotation(): bool {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $isNew = $this->isNewRecord;
            if (!$this->save(false)) {
                $transaction->rollBack();
                return false;
            }

            $flag = true;

            // Normalisasi input ids (boleh kosong)
            $newIds = (array)($this->quotationPendukung ?? []);
            $newIds = array_values(array_unique(array_map('intval', $newIds)));

            if ($isNew) {
                // Insert semua yang baru dipilih
                foreach ($newIds as $quotationPendukungId) {
                    $model = new SuratPerintahKerjaSupportingDocument([
                        'surat_perintah_kerja_id' => $this->id,
                        'quotation_id'            => $quotationPendukungId,
                    ]);
                    if (!$model->save()) {
                        $flag = false;
                        break;
                    }
                }
            } else {


                // Update: sinkronkan relasi pivot berdasarkan diff
                $existingIds = SuratPerintahKerjaSupportingDocument::find()
                    ->select('quotation_id')
                    ->where(['surat_perintah_kerja_id' => $this->id])
                    ->column();

                $toDelete = array_diff($existingIds, $newIds); // yang lama tapi tidak ada di baru
                $toInsert = array_diff($newIds, $existingIds); // yang baru tapi belum ada


                if (!empty($toDelete)) {
                    SuratPerintahKerjaSupportingDocument::deleteAll([
                        'surat_perintah_kerja_id' => $this->id,
                        'quotation_id'            => $toDelete,
                    ]);
                }

                foreach ($toInsert as $quotationPendukungId) {
                    $model = new SuratPerintahKerjaSupportingDocument([
                        'surat_perintah_kerja_id' => $this->id,
                        'quotation_id'            => $quotationPendukungId,
                    ]);
                    if (!$model->save()) {
                        $flag = false;
                        break;
                    }
                }
            }

            if ($flag) {
                $transaction->commit();
                return true;
            }

            $transaction->rollBack();
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }
}
