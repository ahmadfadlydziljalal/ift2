<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_depends_id_column_to_history_lokasi_barang}}`.
 */
class m221226_065708_CreateAddDependsIdColumnToHistoryLokasiBarangTable extends Migration
{

   private string $table = "{{%history_lokasi_barang}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'nomor', $this->string()->after('id'));
      $this->addColumn($this->table, 'depend_id', $this->integer()->null());
      $this->createIndex('idx_depend_id_history_lokasi_barang', $this->table, 'depend_id');
      $this->addForeignKey('fk_depend_id_history_lokasi_barang', $this->table, 'depend_id',
         $this->table,
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
      $this->dropColumn($this->table, 'nomor');
      $this->dropForeignKey('fk_depend_id_history_lokasi_barang', $this->table);
      $this->dropIndex('idx_depend_id_history_lokasi_barang', $this->table);
      $this->dropColumn($this->table, 'depend_id');
   }
}