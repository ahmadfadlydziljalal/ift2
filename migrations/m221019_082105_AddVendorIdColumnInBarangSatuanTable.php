<?php

use yii\db\Migration;

/**
 * Class m221019_082105_AddVendorIdColumnInBarangSatuanTable
 */
class m221019_082105_AddVendorIdColumnInBarangSatuanTable extends Migration
{

    private string $table = "{{barang_satuan}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn($this->table, 'vendor_id', $this->integer()->after('id'));
        $this->update($this->table, ['vendor_id' => 3], ['vendor_id' => null]);
        $this->alterColumn($this->table, 'vendor_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_vendor_id_barang_satuan', $this->table, 'vendor_id');
        $this->addForeignKey('fk_vendor_id_barang_satuan', $this->table, 'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addColumn($this->table, 'harga_beli', $this->decimal(10,2)->defaultValue(0)->after('satuan_id'));
        $this->renameColumn($this->table, 'harga', 'harga_jual');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'harga_jual', 'harga');
        $this->dropColumn($this->table, 'harga_beli');
        $this->dropForeignKey('fk_vendor_id_barang_satuan', $this->table);
        $this->dropIndex('idx_vendor_id_barang_satuan', $this->table);
        $this->dropColumn($this->table, 'vendor_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221019_082105_AddVendorIdColumnInBarangSatuanTable cannot be reverted.\n";

        return false;
    }
    */
}