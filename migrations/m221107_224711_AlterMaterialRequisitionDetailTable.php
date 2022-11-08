<?php

use yii\db\Migration;

/**
 * Class m221107_224711_AlterMaterialRequisitionDetailTable
 */
class m221107_224711_AlterMaterialRequisitionDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_purchase_order_di_material_requisition_detail', 'material_requisition_detail');
        $this->dropIndex('idx_purchase_order_di_material_requisition_detail', 'material_requisition_detail');
        $this->dropColumn('material_requisition_detail', 'purchase_order_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('material_requisition_detail', 'purchase_order_id', $this->integer()->null());
        $this->createIndex('idx_purchase_order_di_material_requisition_detail', 'material_requisition_detail', 'purchase_order_id');
        $this->addForeignKey(
            'fk_purchase_order_di_material_requisition_detail',
            'material_requisition_detail',
            'purchase_order_id',
            'purchase_order',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }
}
