<?php

use yii\db\Migration;

/**
 * Class m221221_130252_AlterBarangTableAddPhotoColumn
 */
class m221221_130252_AlterBarangTableAddPhotoColumn extends Migration
{

   private string $table = "{{%barang}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'photo', $this->text()->null());
      $this->addColumn($this->table, 'photo_thumbnail', $this->text()->null());
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn($this->table, 'photo');
      $this->dropColumn($this->table, 'photo_thumbnail');
   }

}