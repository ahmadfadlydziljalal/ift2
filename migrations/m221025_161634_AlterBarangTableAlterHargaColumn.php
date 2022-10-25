<?php

use yii\db\Migration;

/**
 * Class m221025_161634_AlterBarangTableAlterHargaColumn
 */
class m221025_161634_AlterBarangTableAlterHargaColumn extends Migration
{

    private string $table = "{{barang_satuan}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->table, 'harga_jual', $this->decimal(12, 2));
        $this->alterColumn($this->table, 'harga_beli', $this->decimal(12, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'harga_jual', $this->decimal(10, 2));
        $this->alterColumn($this->table, 'harga_beli', $this->decimal(10, 2));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221025_161634_AlterBarangTableAlterHargaColumn cannot be reverted.\n";

        return false;
    }
    */
}