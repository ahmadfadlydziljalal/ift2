<?php

use yii\db\Migration;

/**
 * Class m221205_132658_AlterHistoryLokasiBarangTable
 */
class m221205_132658_AlterHistoryLokasiBarangTable extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn(
         'history_lokasi_barang',
         'claim_petty_cash_nota_detail_id',
         $this->integer()->null()->after('tanda_terima_barang_detail_id')
      );

      $this->createIndex(
         'idx_claim_petty_cash_nota_detail_di_history_lokasi',
         'history_lokasi_barang',
         'claim_petty_cash_nota_detail_id'
      );

      $this->addForeignKey(
         'idx_claim_petty_cash_nota_detail_di_history_lokasi',
         'history_lokasi_barang',
         'claim_petty_cash_nota_detail_id',
         'claim_petty_cash_nota_detail',
         'id',
         'RESTRICT',
         'CASCADE',
      );

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('idx_claim_petty_cash_nota_detail_di_history_lokasi', 'history_lokasi_barang');
      $this->dropIndex('idx_claim_petty_cash_nota_detail_di_history_lokasi', 'history_lokasi_barang');
      $this->dropColumn('history_lokasi_barang', 'claim_petty_cash_nota_detail_id');
   }
   
}