<?php

use yii\db\Migration;

/**
 * Class m221121_033210_AlterQuotationServiceTable
 */
class m221121_033210_AlterQuotationServiceTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('quotation_service', 'vat_nominal', 'vat_percentage');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('quotation_service', 'vat_percentage', 'vat_nominal');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_033210_AlterQuotationServiceTable cannot be reverted.\n";

        return false;
    }
    */
}