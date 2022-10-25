<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card}}`.
 */
class m221005_075427_CreateCardTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(255)->notNull(),
            'kode' => $this->char(50)->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);
        $this->createTable('card_type', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(255)->notNull(),
            'kode' => $this->char(50)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->string(10),
            'updated_by' => $this->string(10),
        ]);
        $this->batchInsert('card_type', ['nama', 'kode'], [
            ['Customer', 'C'],
            ['Vendor', 'V'],
        ]);
        $this->createTable('card_belongs_type', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'card_type_id' => $this->integer()->notNull(),
            'FOREIGN KEY ([[card_id]]) REFERENCES card ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[card_type_id]]) REFERENCES card_type ([[id]]) ON DELETE RESTRICT ON UPDATE CASCADE',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('card_belongs_type');
        $this->dropTable('card_type');
        $this->dropTable('card');
    }
}