<?php

use yii\db\Migration;

/**
 * Class m221101_224740_AlterMaterialRequisitionDetailTable
 */
class m221101_224740_AlterMaterialRequisitionDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material_requisition_detail', 'vendor_id', $this->integer()->after('satuan_id'));
        $this->createIndex('idx_vendor_di_material_requisition_detail', 'material_requisition_detail', 'vendor_id');
        $this->addForeignKey('fk_vendor_di_material_requisition_detail',
            'material_requisition_detail',
            'vendor_id',
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
        $this->dropForeignKey('fk_vendor_di_material_requisition_detail',
            'material_requisition_detail'
        );
        $this->dropIndex('idx_vendor_di_material_requisition_detail', 'material_requisition_detail');
        $this->dropColumn('material_requisition_detail', 'vendor_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221101_224740_AlterMaterialRequisitionDetailTable cannot be reverted.\n";

        return false;
    }
    */
}