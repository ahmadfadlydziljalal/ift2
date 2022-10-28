<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%claim_petty_cash}}`.
 */
class m221028_173824_CreateClaimPettyCashTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{tipe_pembelian}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'kode' => $this->char('64')->notNull()
        ]);

        $this->batchInsert('tipe_pembelian', [], [
            [1, 'Stock', 'stock'],
            [2, 'Perlengkapan', 'perlengkapan'],
            [3, 'Lain-lain', 'lain-lain'],
        ]);

        $this->createTable('{{%claim_petty_cash}}', [
            'id' => $this->primaryKey(),
            'nomor' => $this->string(128),
            'vendor_id' => $this->integer()->notNull(),
            'tanggal' => $this->date()->notNull(),
            'remarks' => $this->text()->null(),
            'approved_by' => $this->string()->notNull(),
            'acknowledge_by' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createTable('{{%claim_petty_cash_nota}}', [
            'id' => $this->primaryKey(),
            'claim_petty_cash_id' => $this->integer(),
            'nomor' => $this->string(128)->notNull(),
            'vendor_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%claim_petty_cash_nota_detail}}', [
            'id' => $this->primaryKey(),
            'claim_petty_cash_nota_id' => $this->integer(),
            'tipe_pembelian_id' => $this->integer()->notNull(),
            'barang_id' => $this->integer(),
            'description' => $this->string(),
            'quantity' => $this->decimal(10, 2)->notNull(),
            'satuan_id' => $this->integer()->notNull(),
            'harga' => $this->decimal(12, 2)->notNull(),

        ]);

        /* Table claim_petty_cash */
        $this->createIndex(
            'idx_vendor_claim_petty_cash',
            'claim_petty_cash',
            'vendor_id'
        );

        /* Table claim_petty_cash_nota  */
        $this->createIndex(
            'idx_claim_petty_cash_di_nota',
            'claim_petty_cash_nota',
            'claim_petty_cash_id'
        );

        $this->createIndex(
            'idx_vendor_claim_petty_cash_nota',
            'claim_petty_cash_nota',
            'vendor_id'
        );

        /* Table claim_petty_cash_nota_detail */
        $this->createIndex(
            'idx_master_claim_petty_cash_nota_di_detail',
            'claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_id'
        );

        $this->createIndex(
            'idx_tipe_pembelian_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
            'tipe_pembelian_id'
        );

        $this->createIndex(
            'idx_barang_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
            'barang_id'
        );

        $this->createIndex(
            'idx_satuan_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
            'satuan_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%claim_petty_cash_nota_detail}}');
        $this->dropTable('{{%claim_petty_cash_nota}}');
        $this->dropTable('{{%claim_petty_cash}}');
        $this->dropTable('{{%tipe_pembelian}}');
    }
}