<?php

use yii\db\Migration;

/**
 * Class m221103_051553_AlterMaterialRequisitionTable
 */
class m221103_051553_AlterMaterialRequisitionTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('material_requisition', 'approved_by', $this->integer()->notNull());
        $this->alterColumn('material_requisition', 'acknowledge_by', $this->integer()->notNull());

        $this->renameColumn('material_requisition', 'approved_by', 'approved_by_id');
        $this->renameColumn('material_requisition', 'acknowledge_by', 'acknowledge_by_id');

        $this->createIndex('idx_card_approved_by_di_mr', 'material_requisition', 'approved_by_id');
        $this->createIndex('idx_card_acknowledge_by_di_mr', 'material_requisition', 'acknowledge_by_id');

        $this->addForeignKey('fk_card_approved_by_di_mr', 'material_requisition',
            'approved_by_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE',
        );
        $this->addForeignKey('fk_card_acknowledge_by_di_mr', 'material_requisition', 'acknowledge_by_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE',
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_card_approved_by_di_mr', 'material_requisition');
        $this->dropForeignKey('fk_card_acknowledge_by_di_mr', 'material_requisition');

        $this->dropIndex('idx_card_approved_by_di_mr', 'material_requisition');
        $this->dropIndex('idx_card_acknowledge_by_di_mr', 'material_requisition');

        $this->renameColumn('material_requisition', 'approved_by_id', 'approved_by');
        $this->renameColumn('material_requisition', 'acknowledge_by_id', 'acknowledge_by');

        $this->alterColumn('material_requisition', 'approved_by', $this->string()->notNull());
        $this->alterColumn('material_requisition', 'acknowledge_by', $this->string()->notNull());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221103_051553_AlterMaterialRequisitionTable cannot be reverted.\n";

        return false;
    }
    */
}