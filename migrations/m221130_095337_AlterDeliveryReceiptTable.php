<?php

use yii\db\Migration;

/**
 * Class m221130_095337_AlterDeliveryReceiptTable
 */
class m221130_095337_AlterDeliveryReceiptTable extends Migration
{

   public string $table = "{{%quotation_delivery_receipt}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'tanggal_konfirmasi_diterima_customer', $this->date()->null());
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn($this->table, 'tanggal_konfirmasi_diterima_customer');
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221130_095337_AlterDeliveryReceiptTable cannot be reverted.\n";

       return false;
   }
   */
}