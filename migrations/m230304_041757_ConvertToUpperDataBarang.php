<?php

use app\models\Barang;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m230304_041757_ConvertToUpperDataBarang
 */
class m230304_041757_ConvertToUpperDataBarang extends Migration
{

   private string $table;

   public function init()
   {
      $this->table = Barang::tableName();
      parent::init();
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->update($this->table, [
         'nama' => new Expression("UPPER(nama)")
      ]);
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->update($this->table, [
         'nama' => new Expression("LOWER(nama)")
      ]);
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m230304_041757_ConvertToUpperDataBarang cannot be reverted.\n";

       return false;
   }
   */
}