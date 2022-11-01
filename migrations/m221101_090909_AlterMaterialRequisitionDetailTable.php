<?php

use yii\db\Migration;

/**
 * Class m221101_090909_AlterMaterialRequisitionDetailTable
 */
class m221101_090909_AlterMaterialRequisitionDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Tipe pembelian */
        $this->dropForeignKey(
            'fk_tipe_pembelian_detail_material_requisition',
            'material_requisition_detail'
        );
        $this->dropIndex(
            'idx_tipe_pembelian_detail_material_requisition',
            'material_requisition_detail'
        );
        $this->dropColumn('material_requisition_detail', 'tipe_pembelian_id');

        $this->dropForeignKey('fk_barang_detail_material_requisition', 'material_requisition_detail');
        $this->dropIndex('idx_barang_detail_material_requisition', 'material_requisition_detail');

        $this->alterColumn('material_requisition_detail', 'barang_id', $this->integer()->notNull());

        $this->createIndex('idx_barang_detail_material_requisition', 'material_requisition_detail', 'barang_id');
        $this->addForeignKey('fk_barang_detail_material_requisition', 'material_requisition_detail', 'barang_id', 'barang', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('material_requisition_detail', 'barang_id', $this->integer()->null());
        $this->addColumn('material_requisition_detail', 'tipe_pembelian_id', $this->integer()->notNull());
        $this->createIndex(
            'idx_tipe_pembelian_detail_material_requisition',
            'material_requisition_detail',
            'tipe_pembelian_id'
        );
        $this->addForeignKey(
            'fk_tipe_pembelian_detail_material_requisition',
            'material_requisition_detail',
            'tipe_pembelian_id',
            'tipe_pembelian',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221101_090909_AlterMaterialRequisitionDetailTable cannot be reverted.\n";

        return false;
    }
    */
}