<?php

use yii\db\Migration;

/**
 * Class m221120_154510_AlterQuotationAnotherFeeTable
 */
class m221120_154510_AlterQuotationAnotherFeeTable extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quotation', 'delivery_fee', $this->decimal(10, 2));
        $this->addColumn('quotation', 'barang_materai_fee', $this->decimal(10, 2));
        $this->addColumn('quotation', 'service_materai_fee', $this->decimal(10, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quotation', 'delivery_fee');
        $this->dropColumn('quotation', 'barang_materai_fee');
        $this->dropColumn('quotation', 'service_materai_fee');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221120_154510_AlterQuotationAnotherFeeTable cannot be reverted.\n";

        return false;
    }
    */
}