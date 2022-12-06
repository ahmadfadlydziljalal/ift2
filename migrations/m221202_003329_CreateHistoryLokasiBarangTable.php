<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history_lokasi_barang}}`.
 */
class m221202_003329_CreateHistoryLokasiBarangTable extends Migration
{

   private string $table = '{{%history_lokasi_barang}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {

      $this->batchInsert('status', ['id', 'section', 'key', 'value', 'options'], [
         [7, 'set-stock-per-gudang', 'start-pertama-kali-penerapan-sistem', 0, '{ "tag": "span", "options": { "class": "badge bg-secondary" } }'],
         [8, 'set-stock-per-gudang', 'in', 10, '{ "tag": "span", "options": { "class": "badge bg-success" } }'],
         [9, 'set-stock-per-gudang', 'movement-from', 20, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [10, 'set-stock-per-gudang', 'movement-to', 30, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [11, 'set-stock-per-gudang', 'pembatalan', 40, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [12, 'set-stock-per-gudang', 'out', 50, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
      ]);

      $this->createTable('{{%history_lokasi_barang}}', [
         'id' => $this->primaryKey(),
         'tanda_terima_barang_detail_id' => $this->integer(),
         'tipe_pergerakan_id' => $this->integer(),
         'step' => $this->smallInteger()->defaultValue(0)->null(),
         'quantity' => $this->decimal(10, 2)->notNull(),
         'block' => $this->char(8)->notNull(),
         'rak' => $this->char(8)->notNull(),
         'tier' => $this->char(8)->notNull(),
         'row' => $this->char(8)->notNull()
      ]);

      $this->createIndex('idx_status_pergerakan_barang', $this->table, 'tipe_pergerakan_id');
      $this->addForeignKey('fk_status_pergerakan_barang', $this->table, 'tipe_pergerakan_id',
         'status',
         'id',
         'RESTRICT',
         'CASCADE'
      );

      $this->createIndex('idx_ttbd_di_hlb', $this->table, 'tanda_terima_barang_detail_id');
      $this->addForeignKey('fk_ttbd_di_hlb', $this->table, 'tanda_terima_barang_detail_id',
         'tanda_terima_barang_detail',
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

      $this->dropTable('{{%history_lokasi_barang}}');
      $this->delete('status', [
         'IN', 'id', range(7, 12)
      ]);
   }
}