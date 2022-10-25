<?php

use yii\db\Migration;

/**
 * Class m221025_123835_AlterBarangTable
 */
class m221025_123835_AlterBarangTable extends Migration
{

    private string $table = "{{barang}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{originalitas}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'kode' => $this->string(128)->notNull()
        ]);

        $this->batchInsert("{{originalitas}}", ['id', 'nama', 'kode'], [
            [1, 'Genuine', 'genuine'],
            [2, 'Non Genuine', 'non-genuine'],
        ]);

        $this->addColumn($this->table, 'ift_number', $this->string(128)->notNull());
        $this->addColumn($this->table, 'merk_part_number', $this->string());
        $this->addColumn($this->table, 'originalitas_id', $this->integer());

        $this->update($this->table, ['originalitas_id' => 1], ['originalitas_id' => null]);
        $this->alterColumn($this->table, 'originalitas_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'originalitas_id');
        $this->dropColumn($this->table, 'merk_part_number');
        $this->dropColumn($this->table, 'ift_number');
        $this->dropTable('{{originalitas}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221025_123835_AlterBarangTable cannot be reverted.\n";

        return false;
    }
    */
}