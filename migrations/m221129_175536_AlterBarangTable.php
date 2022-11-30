<?php

use yii\db\Migration;

/**
 * Class m221129_175536_AlterBarangTable
 */
class m221129_175536_AlterBarangTable extends Migration
{

    private string $table = "{{%barang}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn(
            $this->table,
            'initialize_stock_quantity',
            $this->decimal(10, 2)
                ->defaultValue(0)
        );

        $this->addColumn(
            $this->table,
            'default_satuan_id',
            $this->integer()
                ->defaultValue(1)
                ->comment('Satuan utama yang dipakai dalam stock')
        );

        $this->alterColumn(
            $this->table,
            'default_satuan_id',
            $this->integer()
                ->notNull()
                ->defaultValue(1)
                ->comment('Satuan utama yang dipakai dalam stock')
        );

        $this->createIndex(
            'idx_satuan_di_barang',
            $this->table,
            'default_satuan_id'
        );

        $this->addForeignKey(
            'fk_satuan_di_barang',
            $this->table,
            'default_satuan_id',
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

        $this->dropForeignKey(
            'fk_satuan_di_barang',
            $this->table
        );


        $this->dropIndex(
            'idx_satuan_di_barang',
            $this->table
        );

        $this->dropColumn(
            $this->table,
            'default_satuan_id'
        );

        $this->dropColumn(
            $this->table,
            'initialize_stock_quantity'
        );
    }
}
