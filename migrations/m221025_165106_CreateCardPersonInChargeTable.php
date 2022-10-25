<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card_person_in_charge}}`.
 */
class m221025_165106_CreateCardPersonInChargeTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card_person_in_charge}}', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer()->notNull(),
            'nama' => $this->string()->notNull(),
            'telepon' => $this->string()->null(),
            'email' => $this->string()
        ]);

        $this->createIndex('idx_card_id_pic', 'card_person_in_charge', 'card_id');
        $this->addForeignKey(
            'fk_card_id_pic',
            'card_person_in_charge',
            'card_id',
            'card',
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
        $this->dropForeignKey('fk_card_id_pic', 'card_person_in_charge');
        $this->dropIndex('idx_card_id_pic', 'card_person_in_charge');
        $this->dropTable('{{%card_person_in_charge}}');
    }
}
