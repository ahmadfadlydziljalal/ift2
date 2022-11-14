<?php

use yii\db\Migration;

/**
 * Class m221114_101153_ALterTandaTerimaBarangDetailTable
 */
class m221114_101153_ALterTandaTerimaBarangDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tanda_terima_barang_detail', 'tanda_terima_barang_id', $this->integer()->after('id'));
        $this->createIndex('idx_tanda_terima_di_tanda_terima_detail', 'tanda_terima_barang_detail',
            'tanda_terima_barang_id'
        );
        $this->addForeignKey('fk_tanda_terima_di_tanda_terima_detail',
            'tanda_terima_barang_detail',
            'tanda_terima_barang_id',
            'tanda_terima_barang',
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
        $this->dropForeignKey('fk_tanda_terima_di_tanda_terima_detail', 'tanda_terima_barang_detail');
        $this->dropIndex('idx_tanda_terima_di_tanda_terima_detail', 'tanda_terima_barang_detail');
        $this->dropColumn('tanda_terima_barang_detail', 'tanda_terima_barang_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_101153_ALterTandaTerimaBarangDetailTable cannot be reverted.\n";

        return false;
    }
    */
}