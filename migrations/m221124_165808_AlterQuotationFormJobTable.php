<?php

use yii\db\Migration;

/**
 * Class m221124_165808_AlterQuotationFormJobTable
 */
class m221124_165808_AlterQuotationFormJobTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey(
            "fk_quotation_di_quotation_form_job",
            "quotation_form_job"
        );

        $this->dropIndex(
            "idx_quotation_di_quotation_form_job",
            "quotation_form_job"
        );

        $this->createIndex(
            "idx_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id",
            true
        );

        $this->addForeignKey(
            "fk_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id",
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            "fk_quotation_di_quotation_form_job",
            "quotation_form_job"
        );

        $this->dropIndex(
            "idx_quotation_di_quotation_form_job",
            "quotation_form_job"
        );

        $this->createIndex(
            "idx_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id",
        );

        $this->addForeignKey(
            "fk_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id",
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221124_165808_AlterQuotationFormJobTable cannot be reverted.\n";

        return false;
    }
    */
}
