<?php

use yii\db\Migration;

/**
 * Class m221101_130556_AlterPurchaseOrderTable
 */
class m221101_130556_AlterPurchaseOrderTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('purchase_order', 'material_requisition_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_material_requisition_id_di_purchase_order', 'purchase_order', 'material_requisition_id');
        $this->addForeignKey('fk_material_requisition_id_di_purchase_order',
            'purchase_order',
            'material_requisition_id',
            'material_requisition',
            'id',
            'RESTRICT',
            'CASCADE',
        );
        $this->dropColumn('purchase_order', 'reference_number');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->addColumn('purchase_order', 'reference_number', $this->string());
        $this->dropForeignKey('fk_material_requisition_id_di_purchase_order', 'purchase_order');
        $this->dropIndex('idx_material_requisition_id_di_purchase_order', 'purchase_order');
        $this->dropColumn('purchase_order', 'material_requisition_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221101_130556_AlterPurchaseOrderTable cannot be reverted.\n";

        return false;
    }
    */
}