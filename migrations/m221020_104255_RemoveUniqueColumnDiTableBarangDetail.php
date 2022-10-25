<?php

use yii\db\Migration;

/**
 * Class m221020_104255_RemoveUniqueColumnDiTableBarangDetail
 */
class m221020_104255_RemoveUniqueColumnDiTableBarangDetail extends Migration
{

    private string $table = "{{barang}}";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->table, 'part_number', $this->char(32)->null());
        $this->dropIndex('part_number', "barang");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'part_number', $this->char(32)->unique()->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221020_104255_RemoveUniqueColumnDiTableBarangDetail cannot be reverted.\n";

        return false;
    }
    */
}