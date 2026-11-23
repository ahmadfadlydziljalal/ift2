<?php

use yii\db\Migration;

class m261120_161454_AlterBarangTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%barang}}', 'initialize_start', $this->date()->null()->after('originalitas_id')->comment('Tanggal awal stock barang'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%barang}}', 'initialize_start');
    }
    
}
