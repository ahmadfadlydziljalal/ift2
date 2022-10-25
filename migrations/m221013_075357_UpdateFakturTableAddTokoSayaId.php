<?php

use yii\db\Migration;

/**
 * Class m221013_075357_UpdateFakturTableAddTokoSayaId
 */
class m221013_075357_UpdateFakturTableAddTokoSayaId extends Migration
{

    private string $table = '{{faktur}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('card_type', ['id' => 3, 'nama' => 'Toko Saya', 'kode' => 'TS']);
        $this->batchInsert('card', ['id', 'nama', 'kode'], [[3, 'SENTRAL TEHKNIK MANDIRI', 'STM'], [4, 'RANS AUTOPARTS', 'Rans'],]);
        $this->addColumn($this->table, 'toko_saya_id', $this->integer());
        $this->update($this->table, ['toko_saya_id' => 3], ['toko_saya_id' => null]);
        $this->alterColumn($this->table, 'toko_saya_id', $this->integer()->notNull());
        $this->batchInsert('card_belongs_type', ['card_id', 'card_type_id'], [
            [3, 3],
            [4, 3],
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'toko_saya_id', $this->integer()->null());
        $this->dropColumn($this->table, 'toko_saya_id');
        $this->delete('card', ['id' => [3, 4]]);
        $this->delete('card_type', ['id' => 3]);


    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221013_075357_UpdateFakturTableAddTokoSayaId cannot be reverted.\n";

        return false;
    }
    */
}