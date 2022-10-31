<?php

use yii\db\Migration;

/**
 * Class m221031_050719_CreateMaterialRequisitionRelation
 */
class m221031_050719_CreateMaterialRequisitionRelation extends Migration
{

    public string $table = '{{%material_requisition}}';
    public string $tableDetail = '{{%material_requisition_detail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_material_requisition_vendor_id',
            $this->table,
            'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_detail_material_requisition',
            $this->tableDetail,
            'material_requisition_id',
            'material_requisition',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_tipe_pembelian_detail_material_requisition',
            $this->tableDetail,
            'tipe_pembelian_id',
            'tipe_pembelian',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_barang_detail_material_requisition',
            $this->tableDetail,
            'barang_id',
            'barang',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_satuan_detail_material_requisition',
            $this->tableDetail,
            'satuan_id',
            'satuan',
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
            'fk_material_requisition_vendor_id',
            $this->table
        );

        $this->dropForeignKey(
            'fk_detail_material_requisition',
            $this->tableDetail
        );

        $this->dropForeignKey(
            'fk_tipe_pembelian_detail_material_requisition',
            $this->tableDetail
        );

        $this->dropForeignKey(
            'fk_barang_detail_material_requisition',
            $this->tableDetail
        );

        $this->dropForeignKey(
            'fk_satuan_detail_material_requisition',
            $this->tableDetail
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221031_050719_CreateMaterialRequisitionRelation cannot be reverted.\n";

        return false;
    }
    */
}