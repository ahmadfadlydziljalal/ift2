<?php

use yii\db\Migration;

/**
 * Class m221128_131201_AlterQuotationDeliveryReceiptDetailTable
 */
class m221128_131201_AlterQuotationDeliveryReceiptDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quotation_delivery_receipt_detail', 'quantity_indent', $this->decimal(10, 2)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quotation_delivery_receipt_detail', 'quantity_indent');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221128_131201_AlterQuotationDeliveryReceiptDetailTable cannot be reverted.\n";

        return false;
    }
    */
}
