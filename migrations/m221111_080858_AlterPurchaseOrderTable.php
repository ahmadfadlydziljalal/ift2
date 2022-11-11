<?php

use yii\db\Migration;

/**
 * Class m221111_080858_AlterPurchaseOrderTable
 */
class m221111_080858_AlterPurchaseOrderTable extends Migration
{
    private string $table = "{{%purchase_order}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Relasi card (vendor_id) ke purchase order */
        $this->dropForeignKey('fk_vendor_di_purchase_order', $this->table);
        $this->dropIndex('idx_vendor_di_purchase_order', $this->table);
        $this->dropColumn($this->table, 'vendor_id');

        /* Relasi material requisition ke purchase order */
        $this->dropForeignKey('fk_material_requisition_id_di_purchase_order', $this->table);
        $this->dropIndex('idx_material_requisition_id_di_purchase_order', $this->table);
        $this->dropColumn($this->table, 'material_requisition_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /* Relasi material requisition ke purchase order */
        $this->addColumn($this->table, 'material_requisition_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_material_requisition_id_di_purchase_order', $this->table, 'material_requisition_id');
        $this->addForeignKey('fk_material_requisition_id_di_purchase_order',
            $this->table,
            'material_requisition_id',
            'material_requisition',
            'id',
            'RESTRICT',
            'CASCADE',
        );

        /* Relasi card (vendor_id) ke purchase order */
        $this->addColumn($this->table, 'vendor_id', $this->integer()->notNull());
        $this->createIndex(
            'idx_vendor_di_purchase_order',
            $this->table,
            'vendor_id'
        );
        $this->addForeignKey(
            'fk_vendor_di_purchase_order',
            $this->table,
            'vendor_id',
            'card',
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
        echo "m221111_080858_AlterPurchaseOrderTable cannot be reverted.\n";

        return false;
    }
    */
}