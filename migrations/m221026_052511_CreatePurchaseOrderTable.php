<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchase_order}}`.
 */
class m221026_052511_CreatePurchaseOrderTable extends Migration
{

    private string $table = '{{%purchase_order}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%purchase_order}}', [
            'id' => $this->primaryKey(),
            'nomor' => $this->string(128),
            'vendor_id' => $this->integer()->notNull(),
            'tanggal' => $this->date()->notNull(),
            'reference_number' => $this->string()->null(),
            'remarks' => $this->text()->null(),
            'approved_by' => $this->string()->notNull(),
            'acknowledge_by' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createTable('{{%purchase_order_detail}}', [
            'id' => $this->primaryKey(),
            'purchase_order_id' => $this->integer(),
            'barang_id' => $this->integer()->notNull(),
            'quantity' => $this->decimal(10, 2),
            'satuan_id' => $this->integer()->notNull(),
            'price' => $this->decimal(12, 2),
        ]);

        /* Relasi card (vendor_id) ke purchase order */
        $this->createIndex(
            'idx_vendor_di_purchase_order',
            $this->table,
            'vendor_id'
        );
        $this->addForeignKey(
            'fk_vendor_di_purchase_order',
            $this->table,
            'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /* Relasi purchase order dengan detail - nya */
        $this->createIndex('idx_purchase_order_di_detail', 'purchase_order_detail', 'purchase_order_id');
        $this->addForeignKey('fk_purchase_order_di_detail',
            'purchase_order_detail',
            'purchase_order_id',
            'purchase_order',
            'id',
            'CASCADE',
            'CASCADE'
        );

        /* Relasi barang ke purchase order detail */
        $this->createIndex('idx_barang_di_purchase_order_detail', 'purchase_order_detail', 'barang_id');
        $this->addForeignKey('fk_barang_di_purchase_order_detail',
            'purchase_order_detail',
            'barang_id',
            'barang',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        /* Relasi satuan barang ke purchase order_detail */
        $this->createIndex(
            'idx_satuan_di_purchase_order_detail',
            'purchase_order_detail',
            'satuan_id'
        );
        $this->addForeignKey(
            'fk_satuan_di_purchase_order_detail',
            'purchase_order_detail',
            'satuan_id',
            'satuan',
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

        /* Relasi satuan barang ke purchase order_detail */
        $this->dropForeignKey('fk_satuan_di_purchase_order_detail', 'purchase_order_detail');
        $this->dropIndex('idx_satuan_di_purchase_order_detail', 'purchase_order_detail');

        /* Relasi card (vendor_id) ke purchase order */
        $this->dropForeignKey('fk_vendor_di_purchase_order', $this->table);
        $this->dropIndex('idx_vendor_di_purchase_order', $this->table);

        /* Relasi purchase order dengan detail - nya */
        $this->dropForeignKey('fk_purchase_order_di_detail', 'purchase_order_detail');
        $this->dropIndex('idx_purchase_order_di_detail', 'purchase_order_detail', 'purchase_order_id');

        /* Relasi barang ke purchase order detail */
        $this->dropForeignKey('fk_barang_di_purchase_order_detail', 'purchase_order_detail');
        $this->dropIndex('idx_barang_di_purchase_order_detail', 'purchase_order_detail', 'barang_id');

        $this->dropTable('{{%purchase_order_detail}}');
        $this->dropTable('{{%purchase_order}}');
    }
}