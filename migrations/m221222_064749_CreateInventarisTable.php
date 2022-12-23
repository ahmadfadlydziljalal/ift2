<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inventaris}}`.
 */
class m221222_064749_CreateInventarisTable extends Migration
{

   private string $tableInventaris = '{{%inventaris}}';
   private string $tableInventarisLaporanPerbaikanMaster = '{{%inventaris_laporan_perbaikan_master}}';
   private string $tableInventarisLaporanPerbaikanDetail = '{{%inventaris_laporan_perbaikan_detail}}';

   private string $tableStatus = '{{%status}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {

      $this->batchInsert($this->tableStatus, ['id', 'section', 'key', 'value', 'options'], [

         [13, 'status-equipment-tool-repair-request', 'pengajuan', 0, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [14, 'status-equipment-tool-repair-request', 'finish', 10, '{ "tag": "span", "options": { "class": "badge bg-success" } }'],

         [15, 'kondisi-equipment-tool-repair-request', 'good', 0, '{ "tag": "span", "options": { "class": "badge bg-success" } }'],
         [16, 'kondisi-equipment-tool-repair-request', 'under-repair', 10, '{ "tag": "span", "options": { "class": "badge bg-success" } }'],
         [17, 'kondisi-equipment-tool-repair-request', 'damage', 20, '{ "tag": "span", "options": { "class": "badge bg-success" } }'],

      ]);

      $this->createTable($this->tableInventaris, [
         'id' => $this->primaryKey(),
         'material_requisition_detail_penawaran_id' => $this->integer()->null(),
         'kode_inventaris' => $this->string(),
         'location_id' => $this->integer()->notNull()->comment('Card Tipe Warehouse'),
         'quantity' => $this->decimal(10, 2)
      ]);

      $this->createIndex('idx_material_requisition_detail_penawaran_id_di_inventaris', $this->tableInventaris, 'material_requisition_detail_penawaran_id');
      $this->createIndex('idx_card_location_di_inventaris', $this->tableInventaris, 'location_id');

      $this->createTable($this->tableInventarisLaporanPerbaikanMaster, [
         'id' => $this->primaryKey(),
         'nomor' => $this->string(),
         'tanggal' => $this->date()->notNull(),
         'card_id' => $this->integer()->notNull()->comment('To'),
         'status_id' => $this->integer()->notNull(),
         'comment' => $this->text(),
         'approved_by_id' => $this->integer()->notNull(),
         'known_by_id' => $this->integer()->notNull(),
         'created_at' => $this->integer(11)->null()->defaultValue(null),
         'updated_at' => $this->integer(11)->null()->defaultValue(null),
         'created_by' => $this->string(10)->null()->defaultValue(null),
         'updated_by' => $this->string(10)->null()->defaultValue(null),
      ]);

      $this->createIndex('idx_card_to_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster, 'card_id');
      $this->createIndex('idx_status_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster, 'status_id');
      $this->createIndex('idx_approved_by_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster, 'approved_by_id');
      $this->createIndex('idx_known_by_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanMaster, 'known_by_id');

      $this->createTable($this->tableInventarisLaporanPerbaikanDetail, [
         'id' => $this->primaryKey(),
         'inventaris_laporan_perbaikan_master_id' => $this->integer(),
         'inventaris_id' => $this->integer()->null(),
         'kondisi_id' => $this->integer()->null(),
         'last_location_id' => $this->integer()->notNull(),
         'last_repaired' => $this->dateTime()->notNull(),
         'remarks' => $this->text(),
         'estimated_price' => $this->decimal(10, 2),
      ]);

      $this->createIndex('idx_inventaris_laporan_perbaikan_master_id_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail, 'inventaris_laporan_perbaikan_master_id');
      $this->createIndex('idx_inventaris_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail, 'inventaris_id');
      $this->createIndex('idx_kondisi_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail, 'kondisi_id');
      $this->createIndex('idx_last_location_di_laporan_perbaikan', $this->tableInventarisLaporanPerbaikanDetail, 'last_location_id');

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->delete($this->tableStatus, 'id >= 13');
      $this->dropTable($this->tableInventarisLaporanPerbaikanDetail);
      $this->dropTable($this->tableInventarisLaporanPerbaikanMaster);
      $this->dropTable($this->tableInventaris);
   }
}