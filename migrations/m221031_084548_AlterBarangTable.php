<?php

use yii\db\Migration;

/**
 * Class m221031_084548_AlterBarangTable
 */
class m221031_084548_AlterBarangTable extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('barang', 'tipe_pembelian_id', $this->integer());
        $this->update('barang',
            [
                'tipe_pembelian_id' => 1
            ],
            [
                'tipe_pembelian_id' => null
            ]
        );
        $this->alterColumn('barang', 'tipe_pembelian_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_tipe_pembelian_di_barang', 'barang', 'tipe_pembelian_id');
        $this->addForeignKey('fk_tipe_pembelian_di_barang',
            'barang',
            'tipe_pembelian_id',
            'tipe_pembelian',
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
        $this->dropColumn('barang', 'tipe_pembelian_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221031_084548_AlterBarangTable cannot be reverted.\n";

        return false;
    }
    */
}