<?php

use yii\db\Migration;

/**
 * Class m221124_080143_AlterQuotationFormJobTable
 */
class m221124_080143_AlterQuotationFormJobTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('quotation_form_job', 'issue', $this->text()->null());
        $this->addColumn('quotation_form_job', 'remarks', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quotation_form_job', 'remarks');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221124_080143_AlterQuotationFormJobTable cannot be reverted.\n";

        return false;
    }
    */
}