<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master_barang}}`.
 */
class m221001_124310_CreateMasterBarangTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{satuan}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull()
        ]);

        $this->createTable('{{%barang}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'part_number' => $this->char(32)->unique(),
            'satuan_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx_satuan_di_barang', 'barang', 'satuan_id');
        $this->addForeignKey('fk_satuan_di_barang',
            'barang',
            'satuan_id',
            'satuan',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%master_barang}}');
    }
}