<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_form_job_jobs}}`.
 */
class m260611_111436_CreateQuotationFormJobJobsTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('{{%quotation_form_job_jobs}}', [
            'id'                    => $this->primaryKey(),
            'quotation_form_job_id' => $this->integer(),
            'type'                  => $this->tinyInteger()->defaultValue(1)->notNull(),
            'nama'                  => $this->string()->notNull(),
            'quantity'              => $this->integer()->notNull(),
            'satuan_id'             => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_quotation_form_job_id', '{{%quotation_form_job_jobs}}', 'quotation_form_job_id');
        $this->addForeignKey(
            'fk_quotation_form_job_id',
            '{{%quotation_form_job_jobs}}',
            'quotation_form_job_id',
            '{{%quotation_form_job}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx_quotation_form_job_satuan_id', '{{%quotation_form_job_jobs}}', 'satuan_id');
        $this->addForeignKey(
            'fk_quotation_form_job_satuan_id',
            '{{%quotation_form_job_jobs}}',
            'satuan_id',
            '{{%satuan}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        $this->dropTable('{{%quotation_form_job_jobs}}');
    }
}
