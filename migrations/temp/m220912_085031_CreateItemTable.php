<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m220912_085031_CreateItemTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'tanggal' => $this->date(),
            'tanggal_waktu' => $this->dateTime()
        ]);

        $this->createTable('{{%item_detail}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'dropdown_item' => $this->string(),
        ]);

        $this->createTable('{{%item_detail_detail}}', [
            'id' => $this->primaryKey(),
            'item_detail_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'dropdown_item' => $this->string(),
        ]);

        $this->createIndex('idx_detail', '{{item_detail}}', 'item_id');
        $this->createIndex('idx_detail_detail', '{{item_detail_detail}}', 'item_detail_id');

        $this->addForeignKey('fk_detail', '{{item_detail}}', 'item_id', '{{item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_detail_detail', '{{item_detail_detail}}', 'item_detail_id', '{{item_detail}}', 'ID', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_detail', '{{item_detail}}');
        $this->dropForeignKey('fk_detail_detail', '{{item_detail_detail}}');


        $this->dropIndex('idx_detail', '{{item_detail}}');
        $this->dropIndex('idx_detail_detail', '{{item_detail_detail}}');


        $this->dropTable('{{%item}}');
        $this->dropTable('{{%item_detail}}');
        $this->dropTable('{{%item_detail_detail}}');
    }
}