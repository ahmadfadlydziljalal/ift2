<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_term_and_condition}}`.
 */
class m221122_152142_CreateQuotationTermAndConditionTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quotation_term_and_condition}}', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(),
            'term_and_condition' => $this->text()->notNull()
        ]);
        $this->createIndex('idx_quotation_di_term_and_condition', 'quotation_term_and_condition', 'quotation_id');
        $this->addForeignKey('fk_quotation_di_term_and_condition', 'quotation_term_and_condition', 'quotation_id'
            , 'quotation',
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
        $this->dropForeignKey('fk_quotation_di_term_and_condition', 'quotation_term_and_condition');
        $this->dropIndex('idx_quotation_di_term_and_condition', 'quotation_term_and_condition');
        $this->dropTable('{{%quotation_term_and_condition}}');
    }
}