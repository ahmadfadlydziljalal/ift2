<?php

use yii\db\Migration;

/**
 * Class m221114_190834_AlterMaterialRequistionDetailPenawaranTable
 */
class m221114_190834_AlterMaterialRequistionDetailPenawaranTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey(
            'fk_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran'
        );

        $this->dropIndex(
            'idx_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran'
        );


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
            'RESTRICT',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran'
        );

        $this->dropIndex(
            'idx_material_requisition_detail_di_penawaran',
            'material_requisition_detail_penawaran'
        );


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
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_190834_AlterMaterialRequistionDetailPenawaranTable cannot be reverted.\n";

        return false;
    }
    */
}