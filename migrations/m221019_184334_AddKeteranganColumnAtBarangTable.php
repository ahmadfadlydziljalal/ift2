<?php

use yii\db\Migration;

/**
 * Class m221019_184334_AddKeteranganColumnAtBarangTable
 */
class m221019_184334_AddKeteranganColumnAtBarangTable extends Migration
{

    private string $table = "{{barang}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'keterangan', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'keterangan');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221019_184334_AddKeteranganColumnAtBarangTable cannot be reverted.\n";

        return false;
    }
    */
}