<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card_own_equipment_history}}`.
 */
class m230403_082927_CreateCardOwnEquipmentHistoryTable extends Migration
{

   private string $table = '{{%card_own_equipment_history}}';

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable($this->table, [
         'id' => $this->primaryKey(),
         'card_own_equipment_id' => $this->integer()->null(),
         'tanggal_service_saat_ini' => $this->date()->notNull(),
         'hour_meter_saat_ini' => $this->integer()->notNull(),
         'kondisi_terakhir' => $this->text()->notNull(),
         'service_terakhir' => $this->integer()->defaultValue(0),
         'service_selanjutnya' => $this->integer()->defaultValue(0),
         'hour_meter_service_selanjutnya' => $this->integer()->defaultValue(0),
         'tanggal_service_selanjutnya' => $this->date()->notNull(),
      ]);
      $this->createIndex('idx_card_own_equipment_di_history', $this->table, 'card_own_equipment_id');
      $this->addForeignKey('fk_card_own_equipment_di_history', $this->table, 'card_own_equipment_id', 'card_own_equipment', 'id', 'CASCADE', 'CASCADE');

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_card_own_equipment_di_history', $this->table);
      $this->dropIndex('idx_card_own_equipment_di_history', $this->table);
      $this->dropTable($this->table);
   }
}