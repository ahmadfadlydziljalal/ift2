<?php

use yii\db\Migration;

/**
 * Class m221121_181921_AlterQuotationTable
 */
class m221121_181921_AlterQuotationTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quotation', 'rekening_id', $this->integer()->null());
        $this->update('quotation', ['rekening_id' => 3], ['>', 'id', 1]);
        $this->alterColumn('quotation', 'rekening_id', $this->integer()->notNull());
        $this->createIndex('idx_rekening_di_quotation', 'quotation', 'rekening_id');
        $this->addForeignKey('fk_rekening_di_quotation',
            'quotation',
            'rekening_id',
            'rekening',
            'id',
            'restrict',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_rekening_di_quotation', 'quotation');
        $this->dropIndex('idx_rekening_di_quotation', 'quotation');
        $this->dropColumn('quotation', 'rekening_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221121_181921_AlterQuotationTable cannot be reverted.\n";

        return false;
    }
    */
}