<?php

use yii\db\Migration;

/**
 * Class m221114_073705_AlterTandaTerimaDetailTable
 */
class m221114_073705_AlterTandaTerimaDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('tanda_terima_barang_detail', 'tanggal');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('tanda_terima_barang_detail', 'tanggal', $this->date()->notNull()
            ->after('material_requisition_detail_penawaran_id')
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_073705_AlterTandaTerimaDetailTable cannot be reverted.\n";

        return false;
    }
    */
}