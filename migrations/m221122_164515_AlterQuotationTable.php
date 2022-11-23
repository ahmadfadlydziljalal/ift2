<?php

use yii\db\Migration;

/**
 * Class m221122_164515_AlterQuotationTable
 */
class m221122_164515_AlterQuotationTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quotation', 'signature_orang_kantor_id', $this->integer()->null());
        $this->update('quotation', ['signature_orang_kantor_id' => 44], ['>', 'id', 1]);
        $this->alterColumn('quotation', 'signature_orang_kantor_id', $this->integer()->notNull());
        $this->createIndex('idx_card_as_signature_orang_kantor_di_quotation', 'quotation', 'signature_orang_kantor_id');
        $this->addForeignKey('fk_card_as_signature_orang_kantor_di_quotation',
            'quotation',
            'signature_orang_kantor_id',
            'card',
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
        $this->dropForeignKey('fk_card_as_signature_orang_kantor_di_quotation', 'quotation');
        $this->dropIndex('idx_card_as_signature_orang_kantor_di_quotation', 'quotation');
        $this->dropColumn('quotation', 'signature_orang_kantor_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221122_164515_AlterQuotationTable cannot be reverted.\n";

        return false;
    }
    */
}