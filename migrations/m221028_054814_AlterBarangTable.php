<?php

use yii\db\Migration;

/**
 * Class m221028_054814_AlterBarangTable
 */
class m221028_054814_AlterBarangTable extends Migration
{
    private string $table = '{{barang}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->table, 'ift_number', $this->string(128)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'ift_number', $this->string(128)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221028_054814_AlterBarangTable cannot be reverted.\n";

        return false;
    }
    */
}