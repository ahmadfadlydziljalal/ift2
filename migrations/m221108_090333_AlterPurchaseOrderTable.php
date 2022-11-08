<?php

use yii\db\Migration;

/**
 * Class m221108_090333_AlterPurchaseOrderTable
 */
class m221108_090333_AlterPurchaseOrderTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->renameColumn('purchase_order', 'approved_by', 'approved_by_id');
        $this->renameColumn('purchase_order', 'acknowledge_by', 'acknowledge_by_id');

        $this->alterColumn('purchase_order', 'approved_by_id', $this->integer()->notNull());
        $this->alterColumn('purchase_order', 'acknowledge_by_id', $this->integer()->notNull());

        $this->createIndex(
            'idx_card_approved_by_di_purchase_order',
            'purchase_order',
            'approved_by_id'
        );

        $this->addForeignKey(
            'fk_card_approved_by_di_purchase_order',
            'purchase_order',
            'approved_by_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex(
            'idx_card_acknowledge_by_di_purchase_order',
            'purchase_order',
            'acknowledge_by_id'
        );

        $this->addForeignKey(
            'fk_card_acknowledge_by_di_purchase_order',
            'purchase_order',
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
        $this->dropForeignKey(
            'fk_card_acknowledge_by_di_purchase_order',
            'purchase_order'
        );

        $this->dropIndex(
            'idx_card_acknowledge_by_di_purchase_order',
            'purchase_order'
        );

        $this->dropForeignKey(
            'fk_card_approved_by_di_purchase_order',
            'purchase_order'
        );

        $this->dropIndex(
            'idx_card_approved_by_di_purchase_order',
            'purchase_order'
        );

        $this->alterColumn('purchase_order', 'approved_by_id', $this->string()->notNull());
        $this->alterColumn('purchase_order', 'acknowledge_by_id', $this->string()->notNull());

        $this->renameColumn('purchase_order', 'acknowledge_by_id', 'acknowledge_by');
        $this->renameColumn('purchase_order', 'approved_by_id', 'approved_by');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221108_090333_AlterPurchaseOrderTable cannot be reverted.\n";

        return false;
    }
    */
}