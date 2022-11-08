<?php

use yii\db\Migration;

/**
 * Class m221108_093750_AlterClaimPettyCashTable
 */
class m221108_093750_AlterClaimPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('claim_petty_cash', 'approved_by', 'approved_by_id');
        $this->renameColumn('claim_petty_cash', 'acknowledge_by', 'acknowledge_by_id');

        $this->alterColumn('claim_petty_cash', 'approved_by_id', $this->integer()->notNull());
        $this->alterColumn('claim_petty_cash', 'acknowledge_by_id', $this->integer()->notNull());

        $this->createIndex(
            'idx_card_approved_by_di_claim_petty_cash',
            'claim_petty_cash',
            'approved_by_id'
        );
        $this->addForeignKey(
            'fk_card_approved_by_di_claim_petty_cash',
            'claim_petty_cash',
            'approved_by_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->createIndex(
            'idx_card_acknowledge_by_di_claim_petty_cash',
            'claim_petty_cash',
            'acknowledge_by_id'
        );
        $this->addForeignKey(
            'fk_card_acknowledge_by_di_claim_petty_cash',
            'claim_petty_cash',
            'acknowledge_by_id',
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
        $this->dropForeignKey('fk_card_acknowledge_by_di_claim_petty_cash', 'claim_petty_cash');
        $this->dropIndex('idx_card_acknowledge_by_di_claim_petty_cash', 'claim_petty_cash');
        $this->dropForeignKey('fk_card_approved_by_di_claim_petty_cash', 'claim_petty_cash');
        $this->dropIndex('idx_card_approved_by_di_claim_petty_cash', 'claim_petty_cash');

        $this->alterColumn('claim_petty_cash', 'acknowledge_by_id', $this->string()->notNull());
        $this->alterColumn('claim_petty_cash', 'approved_by_id', $this->string()->notNull());

        $this->renameColumn('claim_petty_cash', 'acknowledge_by_id', 'acknowledge_by');
        $this->renameColumn('claim_petty_cash', 'approved_by_id', 'approved_by');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221108_093750_AlterClaimPettyCashTable cannot be reverted.\n";

        return false;
    }
    */
}