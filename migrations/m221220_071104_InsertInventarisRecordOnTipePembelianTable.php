<?php

use yii\db\Migration;

/**
 * Class m221220_071104_InsertInventarisRecordOnTipePembelianTable
 */
class m221220_071104_InsertInventarisRecordOnTipePembelianTable extends Migration
{

   private string $table = "{{%tipe_pembelian}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->insert($this->table, ['id' => 4, 'nama' => 'Inventaris', 'kode' => 'inventaris',]);
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->delete($this->table, ['id' => 4]);
   }

}