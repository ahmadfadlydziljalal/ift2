<?php

namespace app\models\form;

use app\enums\TipePergerakanBarangEnum;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;

class StockPerGudangTransferBarangAntarGudang extends Model
{
   public ?string $gudangAsal = null;
   public ?string $namaBarang = null;
   public ?string $quantityOut = null;
   public ?string $block = null;
   public ?string $rak = null;
   public ?string $tier = null;
   public ?string $row = null;
   public ?string $catatan = null;

   /* @var StockPerGudangTransferBarangAntarGudangDetail[] $modelsDetail */
   public ?array $modelsDetail = null;

   protected string $nomorHistoryLokasiBarang;

   public function rules(): array
   {
      return [
         [['gudangAsal', 'namaBarang', 'quantityOut', 'modelsDetail'], 'required'],
         [['block', 'rak', 'tier', 'row', 'catatan'], 'safe']
      ];
   }

   public function save(): bool
   {

      $nomor = HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::MOVEMENT->value);

      $tipePergerakanFrom = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => 'movement-from',
      ]);

      $tipePergerakanTo = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => 'movement-to',
      ]);


      $model = new HistoryLokasiBarang();
      $model->nomor = $nomor;
      $model->card_id = $this->gudangAsal;
      $model->barang_id = (int)$this->namaBarang;
      $model->tipe_pergerakan_id = $tipePergerakanFrom->id;
      $model->quantity = $this->quantityOut;
      $model->block = $this->block;
      $model->rak = $this->rak;
      $model->tier = $this->tier;
      $model->row = $this->row;
      $model->catatan = $this->catatan;


      try {
         $transaction = HistoryLokasiBarang::getDb()->beginTransaction();
         if ($flag = $model->save(false)) {

            foreach ($this->modelsDetail as $detail) :

               if (!$flag) {
                  break;
               }

               $detailSavedStatus = (new HistoryLokasiBarang([
                  'nomor' => $nomor,
                  'tipe_pergerakan_id' => $tipePergerakanTo->id,
                  'card_id' => $detail->gudangTujuan,
                  'quantity' => $detail->quantityIn,
                  'block' => $detail->block,
                  'rak' => $detail->rak,
                  'tier' => $detail->tier,
                  'row' => $detail->row,
                  'catatan' => $detail->catatan,
                  'depend_id' => $model->id
               ]))->save(false);

               if (!$detailSavedStatus) {
                  $flag = false;
                  break;
               }

            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            $this->nomorHistoryLokasiBarang = $nomor;

            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan sukses',
               'message' => 'Transfer berhasil dengan nomor referensi ' . Html::tag('span', $this->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
            ]]);
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         throw new ServerErrorHttpException($e->getMessage());
      }

      Yii::$app->session->setFlash('danger', [[
         'title' => 'Pesan gagal',
         'message' => 'Transfer gagal.'
      ]]);
      return false;
   }


   /**
    * @return mixed
    */
   public function getNomorHistoryLokasiBarang()
   {
      return $this->nomorHistoryLokasiBarang;
   }
}