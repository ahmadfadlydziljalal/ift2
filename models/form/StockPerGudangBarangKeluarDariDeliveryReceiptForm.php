<?php

namespace app\models\form;

use app\enums\SessionSetFlashEnum;
use app\enums\TextLinkEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceipt;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;

class StockPerGudangBarangKeluarDariDeliveryReceiptForm extends Model
{
   const SCENARIO_STEP_1 = 'step-1';
   const SCENARIO_STEP_2 = 'step-2';

   public ?int $nomorDeliveryReceiptId = null;
   public ?QuotationDeliveryReceipt $quotationDeliveryReceipt = null;

   public ?array $quotationDeliveryReceiptDetails = null;

   /**
    * @var HistoryLokasiBarang[] | null;
    */
   public ?array $historyLokasiBarangs = null;
   protected string $nomorHistoryLokasiBarang;

   public function rules(): array
   {
      return [
         ['nomorDeliveryReceiptId', 'required', 'on' => self::SCENARIO_STEP_1]
      ];
   }

   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_STEP_1] = [
         'nomorDeliveryReceiptId'
      ];
      $scenarios[self::SCENARIO_STEP_2] = [
         'nomorDeliveryReceiptId',
         'quotationDeliveryReceiptDetails',
         'historyLokasiBarangs',
      ];
      return $scenarios;
   }

   /**
    * @throws ServerErrorHttpException
    */
   public function save()
   {
      $transaction = HistoryLokasiBarang::getDb()->beginTransaction();
      try {

         $flag = true;

         $nomor = HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::OUT->value);

         foreach ($this->quotationDeliveryReceiptDetails as $i => $item) :
            if (isset($this->historyLokasiBarangs[$i]) && is_array($this->historyLokasiBarangs[$i])) {
               if ($flag === false) break;
               foreach ($this->historyLokasiBarangs[$i] as $modelDetailDetail) {
                  $modelDetailDetail->nomor = $nomor;
                  $modelDetailDetail->quotation_delivery_receipt_detail_id = $item->id;
                  if (!($flag = $modelDetailDetail->save(false))) {
                     break;
                  }
               }

            }

         endforeach;

         if ($flag) {
            $transaction->commit();

            $this->nomorHistoryLokasiBarang = $nomor;
            $this->flashMessage(SessionSetFlashEnum::SUCCESS->value);
            return true;
         }

         $transaction->rollBack();
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException("Database tidak bisa menyimpan data karena " . $e->getMessage());
      }

      $this->flashMessage(SessionSetFlashEnum::DANGER->value);
      return false;
   }

   /**
    * @param string $key
    * @return void
    * @throws ServerErrorHttpException
    */
   protected function flashMessage(string $key = ''): void
   {
      switch ($key) :

         case SessionSetFlashEnum::SUCCESS->value:
            Yii::$app->session->setFlash('success', [[
               'title' => 'Lokasi in berhasil di record.',
               'message' => 'Lokasi Delivery Receipt berhasil disimpan dengan nomor referensi ' . Html::tag('span', $this->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
               'footer' => Html::a(
                  TextLinkEnum::PRINT->value,
                  ['stock-per-gudang/print-barang-keluar-quotation-delivery-receipt', 'id' => $this->quotationDeliveryReceipt->id],
                  [
                     'target' => '_blank',
                     'class' => 'btn btn-primary'
                  ]
               )
            ]]);
            break;

         case SessionSetFlashEnum::DANGER->value:
            Yii::$app->session->setFlash('error', [[
               'title' => 'Gagal',
               'message' => 'Please check again ...!'
            ]]);
            break;

         default:
            throw new ServerErrorHttpException($key . ' tidak ada di setFlash.');

      endswitch;

   }

   /**
    * @return string
    */
   public function getNomorHistoryLokasiBarang(): string
   {
      return $this->nomorHistoryLokasiBarang;
   }

}