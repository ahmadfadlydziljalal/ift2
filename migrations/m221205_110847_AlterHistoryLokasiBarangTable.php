<?php

use yii\db\Migration;

/**
 * Class m221205_110847_AlterHistoryLokasiBarangTable
 */
class m221205_110847_AlterHistoryLokasiBarangTable extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn(
         'history_lokasi_barang',
         'catatan',
         $this->text()
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn(
         'history_lokasi_barang',
         'catatan'
      );
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221205_110847_AlterHistoryLokasiBarangTable cannot be reverted.\n";

       return false;
   }
   */
}