<?php

use yii\db\Migration;

/**
 * Class m221120_035618_AlterQuotationBarangTable
 */
class m221120_035618_AlterQuotationBarangTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('quotation_barang', 'discount', $this->smallInteger()->defaultValue(0));
        $this->renameColumn('quotation_barang', 'vat_nominal', 'vat_percentage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('quotation_barang', 'discount', $this->smallInteger()->null());
        $this->renameColumn('quotation_barang', 'vat_percentage', 'vat_nominal');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221120_035618_AlterQuotationBarangTable cannot be reverted.\n";

        return false;
    }
    */
}