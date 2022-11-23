<?php

use yii\db\Migration;

/**
 * Class m221121_065606_AlterQuotationTable
 */
class m221121_065606_AlterQuotationTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('quotation', 'barang_materai_fee', 'materai_fee');
        $this->dropColumn('quotation', 'service_materai_fee');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('quotation', 'service_materai_fee', $this->decimal(10, 2));
        $this->renameColumn('quotation', 'materai_fee', 'service_materai_fee');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_065606_AlterQuotationTable cannot be reverted.\n";

        return false;
    }
    */
}