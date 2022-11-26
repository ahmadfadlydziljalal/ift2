<?php

use yii\db\Migration;

/**
 * Class m221126_080900_AlterQuotationTable
 */
class m221126_080900_AlterQuotationTable extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->dropForeignKey('fk_quotation_di_delivery_receipt', 'quotation_delivery_receipt');
      $this->dropIndex('idx_quotation_di_delivery_receipt', 'quotation_delivery_receipt');

      $this->createIndex('idx_quotation_di_delivery_receipt', 'quotation_delivery_receipt', 'quotation_id', false);
      $this->addForeignKey('fk_quotation_di_delivery_receipt',
         'quotation_delivery_receipt',
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
      $this->dropIndex('idx_quotation_di_delivery_receipt', 'quotation_delivery_receipt');
      $this->dropForeignKey('fk_quotation_di_delivery_receipt', 'quotation_delivery_receipt');

      $this->createIndex('idx_quotation_di_delivery_receipt', 'quotation_delivery_receipt', 'quotation_id', true);
      $this->addForeignKey('fk_quotation_di_delivery_receipt',
         'quotation_delivery_receipt',
         'quotation_id',
         'quotation',
         'id',
         'CASCADE',
         'CASCADE'
      );
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221126_080900_AlterQuotationTable cannot be reverted.\n";

       return false;
   }
   */
}