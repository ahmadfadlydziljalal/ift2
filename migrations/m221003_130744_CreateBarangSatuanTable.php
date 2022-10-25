<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%barang_satuan}}`.
 */
class m221003_130744_CreateBarangSatuanTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%barang_satuan}}', [
            'id' => $this->primaryKey(),
            'barang_id' => $this->integer(),
            'satuan_id' => $this->integer()->notNull(),
            'harga' => $this->decimal(10, 2)->notNull()
        ]);

        $this->createIndex('idx_barang_satuan', '{{%barang_satuan}}', 'barang_id');
        $this->createIndex('idx_satuan_barang', '{{%barang_satuan}}', 'satuan_id');

        $this->addForeignKey('fk_barang_satuan', '{{%barang_satuan}}', 'barang_id',
            'barang',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey('fk_satuan_barang', '{{%barang_satuan}}', 'satuan_id',
            'satuan',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->dropForeignKey('fk_satuan_di_barang', 'barang');
        $this->dropIndex('idx_satuan_di_barang', 'barang');
        $this->dropColumn('barang', 'satuan_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('barang', 'satuan_id', $this->integer());
        $this->createIndex('idx_satuan_di_barang', 'barang', 'satuan_id');
        $this->addForeignKey('fk_satuan_di_barang',
            'barang',
            'satuan_id',
            'satuan',
            'id'
        );
        $this->dropForeignKey('fk_barang_satuan', '{{%barang_satuan}}');
        $this->dropForeignKey('fk_satuan_barang', '{{%barang_satuan}}');
        $this->dropIndex('idx_barang_satuan', '{{%barang_satuan}}');
        $this->dropIndex('idx_satuan_barang', '{{%barang_satuan}}');
        $this->dropTable('{{%barang_satuan}}');
    }
}