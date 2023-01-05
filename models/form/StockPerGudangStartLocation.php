<?php

namespace app\models\form;

use app\enums\SessionSetFlashEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use Throwable;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\ServerErrorHttpException;
use yii\widgets\DetailView;

class StockPerGudangStartLocation extends Model
{

   public ?string $barangId = null;
   public ?int $cardId = null;
   public ?string $quantity = null;
   public ?string $block = null;
   public ?string $rak = null;
   public ?string $tier = null;
   public ?string $row = null;
   public ?string $catatan = null;

   protected ?string $nomorHistoryLokasiBarang;
   protected ?HistoryLokasiBarang $model;

   /**
    * @return array[]
    */
   public function rules(): array
   {
      return [
         [['barangId', 'cardId', 'quantity', 'block', 'rak', 'tier', 'row'], 'required'],
         [['barangId', 'cardId'], 'integer'],
         [['quantity ', 'block', 'rak', 'tier', 'row', 'catatan'], 'string'],
      ];
   }

   public function attributeLabels(): array
   {
      return [
         'barangId' => "Barang",
         'cardId' => 'Gudang',
         'quantity' => 'Quantity',
         'block' => 'Block',
         'rak' => 'Rak',
         'tier' => 'Tier',
         'row' => 'Row',
         'catatan' => 'Catatan',
      ];
   }

   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_DEFAULT] = [
         'barangId',
         'cardId',
         'quantity',
         'block',
         'rak',
         'tier',
         'row',
         'catatan',
      ];

      return $scenarios;
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {

      $nomor = HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM->value);

      $this->model = new HistoryLokasiBarang([
         'tipe_pergerakan_id' => Status::findOne([
            'section' => Status::SECTION_SET_LOKASI_BARANG,
            'key' => 'start-pertama-kali-penerapan-sistem'
         ])->id,
         'nomor' => $nomor,
         'step' => 0,
         'barang_id' => $this->barangId,
         'card_id' => $this->cardId,
         'quantity' => $this->quantity,
         'block' => $this->block,
         'rak' => $this->rak,
         'tier' => $this->tier,
         'row' => $this->row,
         'catatan' => $this->catatan,
      ]);


      if ($this->model->save(false)) {
         $this->nomorHistoryLokasiBarang = $nomor;
         $this->flashMessage(SessionSetFlashEnum::SUCCESS->value);
         return true;
      }

      $this->flashMessage(SessionSetFlashEnum::DANGER->value);

      return false;
   }

   /**
    * @param string $key
    * @return void
    * @throws ServerErrorHttpException
    * @throws Throwable
    */
   protected function flashMessage(string $key = ''): void
   {
      switch ($key) :
         case SessionSetFlashEnum::SUCCESS->value:

            $gridView = DetailView::widget([
               'model' => $this->model,
               'attributes' => [
                  [
                     'attribute' => 'barang_id',
                     'value' => $this->model->barang->nama
                  ],
                  [
                     'attribute' => 'card_id',
                     'value' => $this->model->card->nama
                  ],
                  'quantity',
                  'block',
                  'rak',
                  'tier',
                  'row',
                  'catatan',
               ]
            ]);

            Yii::$app->session->setFlash('success', [[
               'title' => 'Lokasi Start Project berhasil di record.',
               'message' => 'Lokasi Star Project berhasil disimpan dengan nomor referensi ' .
                  Html::tag('span', $this->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']) . '<br/>' .
                  $gridView
               ,
            ]]);
            break;

         case SessionSetFlashEnum::DANGER->value:
            Yii::$app->session->setFlash('error', [[
               'title' => 'Gagal',
               'message' => 'Please check again ...!'
            ]]);
            break;

         default:
            throw new ServerErrorHttpException($key . ' tidak ada di setFlashMessage.');

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