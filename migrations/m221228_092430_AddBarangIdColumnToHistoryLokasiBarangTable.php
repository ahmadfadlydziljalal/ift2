<?php

use app\models\HistoryLokasiBarang;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%history_lokasi_barang}}`.
 */
class m221228_092430_AddBarangIdColumnToHistoryLokasiBarangTable extends Migration
{

   protected string $table;

   public function init()
   {
      parent::init();
      $this->table = HistoryLokasiBarang::tableName();
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'barang_id',
         $this->integer()->null()->after('id')
            ->comment('Barang ID difungsikan hanya untuk meng-handle saat pertama kali sistem diterapkan')
      );

      $this->createIndex(
         'idx_barang_id_di_history_lokasi_barang',
         $this->table,
         'barang_id'
      );

      $this->addForeignKey(
         'fk_barang_id_di_history_lokasi_barang',
         $this->table,
         'barang_id',
         'barang',
         'id',
         'CASCADE',
         'CASCADE'
      );

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_barang_id_di_history_lokasi_barang', $this->table);
      $this->dropIndex('idx_barang_id_di_history_lokasi_barang', $this->table);
      $this->dropColumn($this->table, 'barang_id');
   }
}