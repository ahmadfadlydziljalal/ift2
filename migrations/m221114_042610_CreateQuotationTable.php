<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation}}`.
 */
class m221114_042610_CreateQuotationTable extends Migration
{

   private string $table = '{{%quotation}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable('{{%quotation}}', [
         'id' => $this->primaryKey(),
         'nomor' => $this->char(128),
         'mata_uang_id' => $this->integer()->notNull()->comment('Mata uang yang akan digunakan'), #index
         'tanggal' => $this->date()->notNull(),
         'customer_id' => $this->integer()->notNull(), # index
         'tanggal_batas_valid' => $this->date()->notNull(),
         'attendant_1' => $this->string(),
         'attendant_phone_1' => $this->string(),
         'attendant_email_1' => $this->string(),
         'attendant_2' => $this->string(),
         'attendant_phone_2' => $this->string(),
         'attendant_email_2' => $this->string(),
         'catatan' => $this->text(),
      ]);
      $this->createIndex('idx_mata_uang_id_di_quotation', 'quotation', 'mata_uang_id');
      $this->createIndex('idx_customer_card_id_di_quotation', 'quotation', 'customer_id');

      $this->createTable('{{quotation_barang}}', [
         'id' => $this->primaryKey(),
         'quotation_id' => $this->integer(), # index
         'barang_id' => $this->integer()->notNull(), #index
         'stock' => $this->decimal(10, 2)->defaultValue(0),
         'quantity' => $this->decimal(10, 2)->notNull(),
         'satuan_id' => $this->integer()->notNull(), #index
         'unit_price' => $this->decimal(12, 2),
         'discount' => $this->smallInteger(),
         'is_vat' => $this->tinyInteger()->defaultValue(0),
         'vat_nominal' => $this->smallInteger()->comment("Satuan persentase")
      ]);
      $this->createIndex('idx_quotation_id_di_quotation_barang', 'quotation_barang', 'quotation_id');
      $this->createIndex('idx_barang_id_di_quotation_barang', 'quotation_barang', 'barang_id');
      $this->createIndex('idx_satuan_id_di_quotation_barang', 'quotation_barang', 'satuan_id');

      $this->createTable('{{quotation_service}}', [
         'id' => $this->primaryKey(),
         'quotation_id' => $this->integer(), #index
         'job_description' => $this->string()->notNull(),
         'hours' => $this->decimal(4, 2),
         'rate_per_hour' => $this->decimal(10, 2),
         'discount' => $this->smallInteger(),
         'is_vat' => $this->tinyInteger()->defaultValue(0),
         'vat_nominal' => $this->smallInteger()->comment("Satuan persentase")
      ]);
      $this->createIndex('idx_quotation_id_di_quotation_service', 'quotation_service', 'quotation_id');

      $this->createTable('{{quotation_another_fee}}', [
         'id' => $this->primaryKey(),
         'quotation_id' => $this->integer(), #index
         'type_another_fee_id' => $this->integer()->notNull(), #index
         'nominal' => $this->decimal(12, 2)
      ]);
      $this->createIndex('idx_quotation_id_di_quotation_another_fee', 'quotation_another_fee', 'quotation_id');
      $this->createIndex('idx_status_id_di_quotation_another_fee', 'quotation_another_fee', 'type_another_fee_id');

      $this->batchInsert('status', ['id', 'section', 'key', 'value', 'options'], [
         [4, 'quotation-another-fee', 'barang', 0, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [5, 'quotation-another-fee', 'service', 10, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
         [6, 'quotation-another-fee', 'lain-lain', 20, '{ "tag": "span", "options": { "class": "badge bg-primary" } }'],
      ]);


   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->delete('status', [
         'IN', 'id', [4, 5, 6]
      ]);
      $this->dropTable('{{%quotation_another_fee}}');
      $this->dropTable('{{%quotation_service}}');
      $this->dropTable('{{%quotation_barang}}');
      $this->dropTable('{{%quotation}}');
   }
}