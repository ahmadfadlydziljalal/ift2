<?php

use yii\db\Migration;

/**
 * Class m221121_052715_AlterQuotationTable
 */
class m221121_052715_AlterQuotationTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('quotation', 'catatan', 'catatan_quotation_barang');
        $this->addColumn('quotation', 'catatan_quotation_service', $this->text()->after('catatan_quotation_barang')->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quotation', 'catatan_quotation_service');
        $this->renameColumn('quotation', 'catatan_quotation_barang', 'catatan');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_052715_AlterQuotationTable cannot be reverted.\n";

        return false;
    }
    */
}