<?php

use yii\db\Migration;

/**
 * Class m221031_093522_RemoveTipePembelianIdDiClaimPettyCashDetailTable
 */
class m221031_093522_RemoveTipePembelianIdDiClaimPettyCashDetailTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey(
            'fk_tipe_pembelian_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail'
        );

        $this->dropIndex(
            'idx_tipe_pembelian_di_claim_petty_cash_nota_detail',
            'claim_petty_cash_nota_detail'
        );

        $this->dropColumn('claim_petty_cash_nota_detail', 'tipe_pembelian_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221031_093522_RemoveTipePembelianIdDiClaimPettyCashDetailTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221031_093522_RemoveTipePembelianIdDiClaimPettyCashDetailTable cannot be reverted.\n";

        return false;
    }
    */
}