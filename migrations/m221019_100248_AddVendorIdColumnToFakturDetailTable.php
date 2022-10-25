<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%faktur_detail}}`.
 */
class m221019_100248_AddVendorIdColumnToFakturDetailTable extends Migration
{

    private string $table = "{{faktur_detail}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->table,'vendor_id', $this->integer()->after('satuan_id'));
        $this->update($this->table, ['vendor_id' => 3], ['vendor_id' => null]);
        $this->alterColumn($this->table, 'vendor_id', $this->integer()->notNull()->after('satuan_id'));

        $this->createIndex('idx_vendor_id_faktur_detail', $this->table, 'vendor_id');
        $this->addForeignKey('fk_vendor_id_faktur_detail', $this->table, 'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_vendor_id_faktur_detail', $this->table);
        $this->dropIndex('idx_vendor_id_faktur_detail', $this->table);
        $this->dropColumn($this->table, 'vendor_id');
    }
}