<?php

use yii\db\Migration;

/**
 * Class m221013_111122_CreateFakturTokoSayaRelation
 */
class m221013_111122_CreateFakturTokoSayaRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_faktur_toko_saya', 'faktur', 'toko_saya_id');
        $this->addForeignKey('fk_faktur_toko_saya', 'faktur', 'toko_saya_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_faktur_toko_saya', 'faktur');
        $this->dropIndex('idx_faktur_toko_saya', 'faktur');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221013_111122_CreateFakturTokoSayaRelation cannot be reverted.\n";

        return false;
    }
    */
}