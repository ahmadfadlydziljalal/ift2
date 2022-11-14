<?php

use yii\db\Migration;

/**
 * Class m221114_071337_CreateQuotationRelation
 */
class m221114_071337_CreateQuotationRelation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_mata_uang_id_di_quotation', 'quotation', 'mata_uang_id',
            'mata_uang',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey('fk_customer_card_id_di_quotation', 'quotation', 'customer_id',
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey('fk_quotation_id_di_quotation_barang', 'quotation_barang', 'quotation_id',
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_barang_id_di_quotation_barang', 'quotation_barang', 'barang_id',
            'barang',
            'id',
            'RESTRICT',
            'CASCADE'

        );
        $this->addForeignKey('fk_satuan_id_di_quotation_barang', 'quotation_barang', 'satuan_id',
            'satuan',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey('fk_quotation_id_di_quotation_service', 'quotation_service', 'quotation_id',
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey('fk_quotation_id_di_quotation_another_fee', 'quotation_another_fee', 'quotation_id',
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey('fk_status_id_di_quotation_another_fee', 'quotation_another_fee', 'type_another_fee_id',
            'status',
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
        $this->dropForeignKey('fk_mata_uang_id_di_quotation', 'quotation');
        $this->dropForeignKey('fk_customer_card_id_di_quotation', 'quotation');
        $this->dropForeignKey('fk_quotation_id_di_quotation_barang', 'quotation_barang');
        $this->dropForeignKey('fk_barang_id_di_quotation_barang', 'quotation_barang');
        $this->dropForeignKey('fk_satuan_id_di_quotation_barang', 'quotation_barang');
        $this->dropForeignKey('fk_quotation_id_di_quotation_service', 'quotation_service');
        $this->dropForeignKey('fk_quotation_id_di_quotation_another_fee', 'quotation_another_fee');
        $this->dropForeignKey('fk_status_id_di_quotation_another_fee', 'quotation_another_fee');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_071337_CreateQuotationRelation cannot be reverted.\n";

        return false;
    }
    */
}