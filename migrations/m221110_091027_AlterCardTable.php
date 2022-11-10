<?php

use yii\db\Migration;

/**
 * Class m221110_091027_AlterCardTable
 */
class m221110_091027_AlterCardTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('card', 'mata_uang_id', $this->integer()->notNull()->defaultValue(1));
        $this->createIndex('idx_mata_uang_di_card', 'card', 'mata_uang_id');
        $this->addForeignKey('fk_mata_uang_di_card',
            'card',
            'mata_uang_id',
            'mata_uang',
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
        $this->dropForeignKey('fk_mata_uang_di_card', 'card');
        $this->dropIndex('idx_mata_uang_di_card', 'card');
        $this->dropColumn('card', 'mata_uang_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221110_091027_AlterCardTable cannot be reverted.\n";

        return false;
    }
    */
}