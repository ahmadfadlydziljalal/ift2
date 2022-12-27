<?php

namespace app\models;

use app\models\base\Barang as BaseBarang;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\imagine\Image;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "barang".
 */
class Barang extends BaseBarang
{

   const SPACES_PATH_DIRECTORY = 'Indoformosa/Barang/';

   public ?string $satuanHarga = null;
   public ?string $satuanNama = null;
   public ?string $originalitasNama = null;
   public ?string $tipePembelianNama = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'ift_number', // required
               'value' => 'IFT-' . '?', // format auto number. '?' will be replaced with generated number
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

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         parent::attributeLabels(), [
            'id' => 'ID',
            'tipe_pembelian_id' => 'Tipe Pembelian',
            'nama' => 'Nama',
            'part_number' => 'Part Number',
            'keterangan' => 'Keterangan',
            'ift_number' => 'IFT Number',
            'merk_part_number' => 'Merk Part Number',
            'originalitas_id' => 'Originalitas',
         ]
      );
   }

   /**
    * @param array $modelsDetail
    * @param array $deletedDetailsID
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function updateWithDetails(array $modelsDetail, array $deletedDetailsID): bool
   {

      $transaction = self::getDb()->beginTransaction();

      try {
         if ($flag = $this->save(false)) {

            if (!empty($deletedDetailsID)) {
               BarangSatuan::deleteAll(['id' => $deletedDetailsID]);
            }

            foreach ($modelsDetail as $detail) :
               $detail->barang_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            Yii::$app->session->setFlash(
               'info',
               "Barang: " . Html::a($this->nama, ['view', 'id' => $this->id]) . " berhasil di update."
            );
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      Yii::$app->session->setFlash(
         'danger',
         " Barang is failed to updated."
      );
      return false;
   }

   /**
    * @param BarangSatuan[] $modelsDetail
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function createWithDetails(array $modelsDetail): bool
   {

      $transaction = self::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) {

            foreach ($modelsDetail as $detail) :
               $detail->barang_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;

         }

         if ($flag) {
            $transaction->commit();
            Yii::$app->session->setFlash('success',
               'Barang: ' . Html::a($this->nama, ['view', 'id' => $this->id]) . " berhasil ditambahkan."
            );
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      Yii::$app->session->setFlash('danger', " Barang is failed to insert.");
      return false;
   }

   protected function uploadToSpaces($iftNumber, $name, $tmpName, $thumbnailFile): bool
   {

      $extension = pathinfo($name, PATHINFO_EXTENSION);

      $directory = self::SPACES_PATH_DIRECTORY . $iftNumber . '/';
      $pathFile = $directory . 'photo.' . $extension;
      $pathThumbnail = $directory . '_thumb.' . $extension;

      /* Upload to spaces  */
      $storage = Yii::$app->spaces;
      $storage->commands()->upload($pathFile, $tmpName)->execute();
      $storage->commands()->upload($pathThumbnail, $thumbnailFile)->execute();

      /* Save to local */
      $this->photo = $storage->getUrl($pathFile);
      $this->photo_thumbnail = $storage->getUrl($pathThumbnail);

      return $this->save(false);

   }

   /** Upload file to spaces, then save those information to database.
    * If success, return empty array, otherwise return array with error information
    * @param mixed $files
    * @param array $post
    * @return mixed
    * @throws Exception
    */
   public function upload(mixed $files, array $post): array
   {

      if (!empty($files["error"])) {
         return $files["error"];
      }

      // Membuat thumbnail photo dengan resolusi tertentu
      $thumbnailFile = $this->createThumbnailImage($files);

      // Upload and save to database
      $statusUploadToSpaces = $this->uploadToSpaces(
         $post['ift_number'],
         $files['name'],
         $files['tmp_name'],
         $thumbnailFile
      );

      // Berhasil upload atau tidak, tetap hapus file thumbnail yang sudah dibuat
      FileHelper::unlink($thumbnailFile);

      // Catch error, kalau gagal menyimpan informasi photonya
      if (!$statusUploadToSpaces) {
         throw new Exception("Gagal save photo...!" . Html::tag('pre', VarDumper::dumpAsString($this->errors)));
      }

      return [];

   }

   /**
    * Return path directory dari thumb image
    * @param $files
    * @param int $width
    * @param int $height
    * @param int $quality
    * @return string
    */
   protected function createThumbnailImage($files, int $width = 128, int $height = 128, int $quality = 100): string
   {
      $thumbnailFile = '/tmp/' . $files['name'];
      Image::thumbnail($files['tmp_name'], $width, $height)
         ->save($thumbnailFile, ['quality' => $quality]);
      return $thumbnailFile;
   }
}