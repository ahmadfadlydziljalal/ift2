<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_delivery_receipt}}`.
 */
class m221125_042707_CreateQuotationDeliveryReceiptTable extends Migration
{

   private string $table = '{{%quotation_delivery_receipt}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable('{{%quotation_delivery_receipt}}', [
         'id' => $this->primaryKey(),
         'quotation_id' => $this->integer(),
         'nomor' => $this->string(),
         'tanggal' => $this->date()->notNull(),
         'purchase_order_number' => $this->string(),
         'checker' => $this->string(),
         'vehicle' => $this->string(),
         'remarks' => $this->text()
      ]);

      $this->createIndex('idx_quotation_di_delivery_receipt', 'quotation_delivery_receipt', 'quotation_id', true);
      $this->addForeignKey('fk_quotation_di_delivery_receipt', 'quotation_delivery_receipt',
         'quotation_id',
         'quotation',
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
      $this->dropTable('{{%quotation_delivery_receipt}}');
   }
}