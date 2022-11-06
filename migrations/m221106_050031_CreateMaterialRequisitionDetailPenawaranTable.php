<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%material_requisition_detail_penawaran}}`.
 */
class m221106_050031_CreateMaterialRequisitionDetailPenawaranTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%material_requisition_detail_penawaran}}', [
            'id' => $this->primaryKey(),
            'material_requisition_detail_id' => $this->integer(),
            'vendor_id' => $this->integer()->notNull(),
            'harga_penawaran' => $this->decimal(12, 2)->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createIndex(
            'idx_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran',
            'material_requisition_detail_id'
        );
        $this->addForeignKey(
            'fk_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran',
            'material_requisition_detail_id',
            'material_requisition_detail',
            'id',
            'CASCADE',
            'CASCADE',
        );

        $this->createIndex(
            'idx_vendor_di_penawaran',
            'material_requisition_detail_penawaran',
            'vendor_id'
        );
        $this->addForeignKey(
            'fk_vendor_di_penawaran',
            'material_requisition_detail_penawaran',
            'vendor_id',
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
        $this->dropTable('{{%material_requisition_detail_penawaran}}');
    }
}