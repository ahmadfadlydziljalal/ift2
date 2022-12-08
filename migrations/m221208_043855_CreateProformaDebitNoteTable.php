<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proforma_debit_note}}`.
 */
class m221208_043855_CreateProformaDebitNoteTable extends Migration
{

   private string $tableMaster = '{{%proforma_debit_note}}';
   private string $tableDetailBarang = '{{%proforma_debit_note_detail_barang}}';
   private string $tableDetailService = '{{%proforma_debit_note_detail_service}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable($this->tableMaster, [
         'id' => $this->primaryKey(),
         'quotation_id' => $this->integer()->notNull(),
         'nomor' => $this->string(128),
         'tanggal' => $this->date()->null(),
         'pph_23_percent' => $this->smallInteger()->defaultValue(0)
      ]);

      $this->createIndex(
         'idx_quotation_id_di_proforma_debit_note',
         $this->tableMaster,
         'quotation_id',
         true
      );

      $this->createTable($this->tableDetailBarang, [
         'id' => $this->primaryKey(),
         'proforma_debit_note_id' => $this->integer(),
         'barang_id' => $this->integer()->notNull(), #index
         'stock' => $this->decimal(10, 2)->defaultValue(0),
         'quantity' => $this->decimal(10, 2)->notNull(),
         'satuan_id' => $this->integer()->notNull(), #index
         'unit_price' => $this->decimal(12, 2),
         'discount' => $this->smallInteger(),
         'is_vat' => $this->tinyInteger()->defaultValue(0),
      ]);

      $this->createIndex(
         'idx_proforma_debit_note_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'proforma_debit_note_id');
      $this->createIndex(
         'idx_barang_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'barang_id');
      $this->createIndex(
         'idx_satuan_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'satuan_id');

      $this->createTable($this->tableDetailService, [
         'id' => $this->primaryKey(),
         'proforma_debit_note_id' => $this->integer(), #index
         'job_description' => $this->string()->notNull(),
         'hours' => $this->decimal(4, 2),
         'rate_per_hour' => $this->decimal(10, 2),
         'discount' => $this->smallInteger(),
         'is_vat' => $this->tinyInteger()->defaultValue(0),
      ]);

      $this->createIndex(
         'idx_proforma_debit_note_id_di_proforma_debit_note_detail_service',
         $this->tableDetailService,
         'proforma_debit_note_id'
      );

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropTable($this->tableDetailService);
      $this->dropTable($this->tableDetailBarang);
      $this->dropTable($this->tableMaster);
   }
}