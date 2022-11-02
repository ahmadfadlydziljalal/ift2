<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%purchase_order_detail}}`.
 */
class m221102_060623_DropPurchaseOrderDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%purchase_order_detail}}');

        $this->addColumn('material_requisition_detail', 'purchase_order_id', $this->integer()->null()->after('vendor_id'));
        $this->createIndex('idx_purchase_order_di_material_requisition_detail', 'material_requisition_detail', 'purchase_order_id');
        $this->addForeignKey('fk_purchase_order_di_material_requisition_detail',
            'material_requisition_detail',
            'purchase_order_id',
            'purchase_order',
            'id',
            'SET NULL',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_purchase_order_di_material_requisition_detail', 'material_requisition_detail');
        $this->dropIndex('idx_purchase_order_di_material_requisition_detail', 'material_requisition_detail');

        $this->createTable('{{%purchase_order_detail}}', [
            'id' => $this->primaryKey(),
            'purchase_order_id' => $this->integer(),
            'barang_id' => $this->integer()->notNull(),
            'quantity' => $this->decimal(10, 2),
            'satuan_id' => $this->integer()->notNull(),
            'price' => $this->decimal(12, 2),
        ]);

        $this->createIndex('idx_purchase_order_di_detail', 'purchase_order_detail', 'purchase_order_id');
        $this->addForeignKey('fk_purchase_order_di_detail',
            'purchase_order_detail',
            'purchase_order_id',
            'purchase_order',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /* Relasi barang ke purchase order detail */
        $this->createIndex('idx_barang_di_purchase_order_detail', 'purchase_order_detail', 'barang_id');
        $this->addForeignKey('fk_barang_di_purchase_order_detail',
            'purchase_order_detail',
            'barang_id',
            'barang',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /* Relasi satuan barang ke purchase order_detail */
        $this->createIndex(
            'idx_satuan_di_purchase_order_detail',
            'purchase_order_detail',
            'satuan_id'
        );
        $this->addForeignKey(
            'fk_satuan_di_purchase_order_detail',
            'purchase_order_detail',
            'satuan_id',
            'satuan',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }
}