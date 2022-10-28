<?php

use yii\db\Migration;

/**
 * Class m221028_175303_CreateClaimPettyCashRelation
 */
class m221028_175303_CreateClaimPettyCashRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Table claim_petty_cash */
        $this->addForeignKey(
            'fk_vendor_claim_petty_cash',
            'claim_petty_cash',
            'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /* Table claim_petty_cash_nota  */
        $this->addForeignKey(
            'fk_claim_petty_cash_di_nota',
            'claim_petty_cash_nota',
            'claim_petty_cash_id',
            'claim_petty_cash',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_vendor_claim_petty_cash_nota',
            'claim_petty_cash_nota',
            'vendor_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /* Table claim_petty_cash_nota_detail */
        $this->addForeignKey(
            'fk_master_claim_petty_cash_nota_di_detail',
            'claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_id',
            'claim_petty_cash_nota',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_tipe_pembelian_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
            'tipe_pembelian_id',
            'tipe_pembelian',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_barang_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
            'barang_id',
            'barang',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_satuan_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail',
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
        /* Table claim_petty_cash */
        $this->dropForeignKey(
            'fk_vendor_claim_petty_cash',
            'claim_petty_cash'
        );

        /* Table claim_petty_cash_nota  */
        $this->dropForeignKey(
            'fk_claim_petty_cash_di_nota',
            'claim_petty_cash_nota'
        );

        $this->dropForeignKey(
            'fk_vendor_claim_petty_cash_nota',
            'claim_petty_cash_nota'
        );

        /* Table claim_petty_cash_nota_detail */
        $this->dropForeignKey(
            'fk_master_claim_petty_cash_nota_di_detail',
            'claim_petty_cash_nota_detail'
        );

        $this->dropForeignKey(
            'fk_tipe_pembelian_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail'
        );

        $this->dropForeignKey(
            'fk_barang_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail'
        );

        $this->dropForeignKey(
            'fk_satuan_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221028_175303_CreateClaimPettyCashRelation cannot be reverted.\n";

        return false;
    }
    */
}