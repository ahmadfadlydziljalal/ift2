<?php

use yii\db\Migration;

/**
 * Class m221121_171127_AlterRekeningTable
 */
class m221121_171127_AlterRekeningTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('rekening', 'card_id', $this->integer()->after('id'));
        $this->update('rekening', ['card_id' => 7], ['>', 'id', 1]);
        $this->alterColumn('rekening', 'card_id', $this->integer()->after('id')->notNull());
        $this->createIndex('idx_card_di_rekening', 'rekening', 'card_id');
        $this->addForeignKey('fk_card_di_rekening', 'rekening',
            'card_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->alterColumn('rekening', 'atas_nama', $this->text()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_card_di_rekening', 'rekening');
        $this->dropIndex('idx_card_di_rekening', 'rekening');
        $this->dropColumn('rekening', 'card_id');
        $this->alterColumn('rekening', 'atas_nama', $this->string()->notNull());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_171127_AlterRekeningTable cannot be reverted.\n";

        return false;
    }
    */
}