<?php

use yii\db\Migration;

/**
 * Class m221005_083102_AddCardIdInFakturTable
 */
class m221005_083102_AddCardIdInFakturTable extends Migration
{

    private string $table = "{{faktur}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'card_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_card_id_di_faktur', $this->table, 'card_id');
        $this->addForeignKey('fk_card_id_di_faktur', $this->table,
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
        $this->dropColumn($this->table, 'card_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221005_083102_AddCardIdInFakturTable cannot be reverted.\n";

        return false;
    }
    */
}