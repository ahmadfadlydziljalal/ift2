<?php

use yii\db\Migration;

/**
 * Class m221114_100708_ALterMaterialRequisitionDetailPenawaranTable
 */
class m221114_100708_ALterMaterialRequisitionDetailPenawaranTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_tanda_terima_di_mr_detail_penawaran', 'material_requisition_detail_penawaran');
        $this->dropIndex('idx_tanda_terima_di_mr_detail_penawaran', 'material_requisition_detail_penawaran');
        $this->dropColumn('material_requisition_detail_penawaran', 'tanda_terima_barang_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('material_requisition_detail_penawaran', 'tanda_terima_barang_id', $this->integer()->after('purchase_order_id'));
        $this->createIndex('idx_tanda_terima_di_mr_detail_penawaran', 'material_requisition_detail_penawaran',
            'tanda_terima_barang_id'
        );
        $this->addForeignKey('fk_tanda_terima_di_mr_detail_penawaran',
            'material_requisition_detail_penawaran',
            'tanda_terima_barang_id',
            'tanda_terima_barang',
            'id',
            'SET NULL',
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
        echo "m221114_100708_ALterMaterialRequisitionDetailPenawaranTable cannot be reverted.\n";

        return false;
    }
    */
}