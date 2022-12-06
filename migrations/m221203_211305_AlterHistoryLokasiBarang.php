<?php

use yii\db\Migration;

/**
 * Class m221203_211305_AlterHistoryLokasiBarang
 */
class m221203_211305_AlterHistoryLokasiBarang extends Migration
{
   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn('history_lokasi_barang', 'card_id',
         $this->integer()
            ->notNull()
            ->after('id')
            ->comment('Card yang bertindak sebagai warehouse')
      );

      $this->createIndex('idx_card_id_di_history_lokasi_barang', 'history_lokasi_barang', 'card_id');
      $this->addForeignKey('fk_card_id_di_history_lokasi_barang',
         'history_lokasi_barang',
         'card_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_card_id_di_history_lokasi_barang', 'history_lokasi_barang');
      $this->dropIndex('idx_card_id_di_history_lokasi_barang', 'history_lokasi_barang');
      $this->dropColumn('history_lokasi_barang', 'card_id');
   }
   
}