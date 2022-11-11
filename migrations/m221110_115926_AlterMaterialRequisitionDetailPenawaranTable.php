<?php

use yii\db\Migration;

/**
 * Class m221110_115926_AlterMaterialRequisitionDetailPenawaranTable
 */
class m221110_115926_AlterMaterialRequisitionDetailPenawaranTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material_requisition_detail_penawaran', 'quantity_pesan',
            $this->decimal(10, 2)
                ->defaultValue(1)
                ->notNull()
                ->after('mata_uang_id')


        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('material_requisition_detail_penawaran', 'quantity_pesan');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221110_115926_AlterMaterialRequisitionDetailPenawaranTable cannot be reverted.\n";

        return false;
    }
    */
}