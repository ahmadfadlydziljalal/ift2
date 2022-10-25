<?php

use yii\db\Migration;

/**
 * Class m221003_122117_CreateFakturDetailSatuanRelation
 */
class m221003_122117_CreateFakturDetailSatuanRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_satuan_di_faktur_detail', 'faktur_detail', 'satuan_id');
        $this->addForeignKey('fk_satuan_di_faktur_detail', 'faktur_detail',
            'satuan_id',
            'satuan',
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
        $this->dropForeignKey('fk_satuan_di_faktur_detail', 'faktur_detail');
        $this->dropIndex('idx_satuan_di_faktur_detail', 'faktur_detail');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221003_122117_CreateFakturDetailSatuanRelation cannot be reverted.\n";

        return false;
    }
    */
}