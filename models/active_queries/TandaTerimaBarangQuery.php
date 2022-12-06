<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\TandaTerimaBarang;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\TandaTerimaBarang]].
 *
 * @see \app\models\TandaTerimaBarang
 */
class TandaTerimaBarangQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return TandaTerimaBarang|array|null
    */
   public function one($db = null): TandaTerimaBarang|array|null
   {
      return parent::one($db);
   }

   /**
    * @return array
    */
   public function mapBelumAdaDataLokasi(): array
   {
      $query = parent::select([
         'id' => 'tanda_terima_barang.id',
         'nomor' => 'tanda_terima_barang.nomor'
      ])
         ->joinWith(['tandaTerimaBarangDetails' => function ($ttbd) {
            $ttbd->joinWith('historyLokasiBarangs');
         }])
         ->where([
            'IS', 'history_lokasi_barang.id', NULL
         ])
         ->groupBy('tanda_terima_barang.id');

      return ArrayHelper::map($query->all(), 'id', 'nomor');
   }

   /**
    * @return array
    */
   public function map(): array
   {
      return ArrayHelper::map(parent::all(), 'id', 'nomor');
   }

   /**
    * @inheritdoc
    * @return TandaTerimaBarang[]|array
    */
   public function all($db = null): array
   {
      return parent::all($db);
   }

   /**
    * @param mixed $q
    * @return TandaTerimaBarang[] | array
    */
   public function byNomor(mixed $q): array
   {
      return parent::select([
         'id' => 'id',
         'text' => 'nomor'
      ])
         ->where([
            'LIKE', 'tanda_terima_barang.nomor', $q
         ])
         ->asArray()
         ->all();
   }
}