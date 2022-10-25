<?php

use yii\db\Migration;

/**
 * Class m221025_193002_CreateCardOwnEquipment
 */
class m221025_193002_CreateCardOwnEquipment extends Migration
{

    private string $table = "{{card_own_equipment}}";


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer()->notNull(),
            'nama' => $this->string()->notNull()->comment("Equipment's name"),
            'lokasi' => $this->text()->notNull()->comment("Equipment's location"),
            'tanggal_produk' => $this->date()->notNull()->comment('Date of Product'),
            'serial_number' => $this->string()->notNull()->comment('SN')
        ]);
        $this->createIndex('idx_card_id_card_own_equipment', 'card_own_equipment', 'card_id');
        $this->addForeignKey(
            'fk_card_id_card_own_equipment',
            'card_own_equipment',
            'card_id',
            'card',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_card_id_card_own_equipment', 'card_own_equipment');
        $this->dropIndex('idx_card_id_card_own_equipment', 'card_own_equipment');
        $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221025_193002_CreateCardOwnEquipment cannot be reverted.\n";

        return false;
    }
    */
}