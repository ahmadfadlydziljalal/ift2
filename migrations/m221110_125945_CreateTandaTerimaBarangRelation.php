<?php

use yii\db\Migration;

/**
 * Class m221110_125945_CreateTandaTerimaBarangRelation
 */
class m221110_125945_CreateTandaTerimaBarangRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_card_acknowledge_di_tanda_terima_barang',
            'tanda_terima_barang',
            'acknowledge_by_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        $this->addForeignKey('fk_tanda_terima_di_mr_detail_penawaran',
            'material_requisition_detail_penawaran',
            'tanda_terima_barang_id',
            'tanda_terima_barang',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey('fk_mr_detail_penawaran_di_tanda_terima_barang_detail',
            'tanda_terima_barang_detail',
            'material_requisition_detail_penawaran_id',
            'material_requisition_detail_penawaran',
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
        $this->dropForeignKey(
            'fk_card_acknowledge_di_tanda_terima_barang',
            'tanda_terima_barang'
        );


        $this->dropForeignKey('fk_tanda_terima_di_mr_detail_penawaran',
            'material_requisition_detail_penawaran'
        );

        $this->dropForeignKey('fk_mr_detail_penawaran_di_tanda_terima_barang_detail',
            'tanda_terima_barang_detail'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221110_125945_CreateTandaTerimaBarangRelation cannot be reverted.\n";

        return false;
    }
    */
}