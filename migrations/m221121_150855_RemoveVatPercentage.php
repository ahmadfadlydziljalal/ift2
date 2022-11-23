<?php

use yii\db\Migration;

/**
 * Class m221121_150855_RemoveVatPercentage
 */
class m221121_150855_RemoveVatPercentage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('quotation_barang', 'vat_percentage');
        $this->dropColumn('quotation_service', 'vat_percentage');
        $this->addColumn('quotation', 'vat_percentage', $this->smallInteger()->defaultValue(0)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quotation', 'vat_percentage');
        $this->addColumn('quotation_barang', 'vat_percentage', $this->smallInteger());
        $this->addColumn('quotation_service', 'vat_percentage', $this->smallInteger());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_150855_RemoveVatPercentage cannot be reverted.\n";

        return false;
    }
    */
}