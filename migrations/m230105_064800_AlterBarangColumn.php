<?php

use app\models\Barang;
use yii\db\Migration;

/**
 * Class m230105_064800_AlterBarangColumn
 */
class m230105_064800_AlterBarangColumn extends Migration
{

   private string $table;

   public function init()
   {
      parent::init();
      $this->table = Barang::tableName();
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'price_per_item_in_usd',
         $this->decimal(16, 2)
            ->defaultValue(0)
            ->comment('Pertama kali penggunaan sistem. Karena based on time, nilai ini akan selalu berubah, contohnya melalui pembelian')
      );
      $this->addColumn($this->table, 'price_per_item_in_idr',
         $this->decimal(16, 2)
            ->defaultValue(0)
            ->comment('Pertama kali penggunaan sistem. Karena based on time, nilai ini akan selalu berubah, contohnya melalui pembelian')
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn($this->table, 'price_per_item_in_idr');
      $this->dropColumn($this->table, 'price_per_item_in_usd');
   }

}