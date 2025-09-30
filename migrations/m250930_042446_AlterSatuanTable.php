<?php

use yii\db\Migration;

class m250930_042446_AlterSatuanTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('satuan', 'kategori', $this->tinyInteger()->null()->defaultValue(1)->comment('1=Barang, 2=Jasa, 3=Keduanya'));
        $this->insert('satuan', [
            'id' => 13,
            'nama' => 'HOUR',
            'kategori' => 2
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->delete('satuan', [
            'id' => 13,
            'nama' => 'HOUR',
            'kategori' => 2
        ]);
        $this->dropColumn('satuan', 'kategori');
    }

}
