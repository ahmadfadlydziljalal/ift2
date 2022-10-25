<?php

use yii\db\Migration;

/**
 * Class m221025_131216_CreateBarangDenganOriginalitasRelation
 */
class m221025_131216_CreateBarangDenganOriginalitasRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_orginalitas_barang', 'barang', 'originalitas_id');
        $this->addForeignKey('fk_orginalitas_barang', 'barang',
            'originalitas_id',
            'originalitas',
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
        $this->dropForeignKey('fk_orginalitas_barang', 'barang');
        $this->dropIndex('idx_orginalitas_barang', 'barang');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221025_131216_CreateBarangDenganOriginalitasRelation cannot be reverted.\n";

        return false;
    }
    */
}