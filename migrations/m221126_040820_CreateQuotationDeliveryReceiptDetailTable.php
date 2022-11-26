<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_delivery_receipt_detail}}`.
 */
class m221126_040820_CreateQuotationDeliveryReceiptDetailTable extends Migration
{

   private string $table = '{{%quotation_delivery_receipt_detail}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable($this->table, [
         'id' => $this->primaryKey(),
         'quotation_barang_id' => $this->integer()->notNull(),
         'quotation_delivery_receipt_id' => $this->integer(),
         'quantity' => $this->decimal(10, 2)->notNull()
      ]);

      $this->createIndex('idx_qb_di_delivery_receipt_detail', $this->table, 'quotation_barang_id');
      $this->createIndex('idx_qdr_di_delivery_receipt_detail', $this->table, 'quotation_delivery_receipt_id');

      $this->addForeignKey('idx_qb_di_delivery_receipt_detail', $this->table, 'quotation_barang_id',
         'quotation_barang',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey('idx_qdr_di_delivery_receipt_detail', $this->table, 'quotation_delivery_receipt_id',
         'quotation_delivery_receipt',
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
      $this->dropTable($this->table);
   }
}