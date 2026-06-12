<?php

use yii\db\Migration;

class m260612_094341_RemoveTypeColumnInQuotationFormJobJobs extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->dropColumn('{{%quotation_form_job_jobs}}', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        $this->addColumn('{{%quotation_form_job_jobs}}', 'type', $this->tinyInteger()->defaultValue(1)->notNull());
    }

   
}
