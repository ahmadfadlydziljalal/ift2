<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tanda_terima_barang}}`.
 */
class m221110_116539_CreateTandaTerimaBarangTable extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tanda_terima_barang', [
            'id' => $this->primaryKey(),
            'nomor' => $this->string(128),
            'tanggal' => $this->date()->notNull(),
            'catatan' => $this->text(),
            'received_by' => $this->string()->notNull()->comment('Ketik manual nama penerima'),
            'messenger' => $this->string()->notNull()->comment('Ketik manual nama messenger yang mengantarkan barang'),
            'acknowledge_by_id' => $this->integer()->notNull()->comment('Orang kantor yang mengetahui'),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);
        $this->createIndex(
            'idx_card_acknowledge_di_tanda_terima_barang',
            'tanda_terima_barang',
            'acknowledge_by_id'
        );

        $this->addColumn('material_requisition_detail_penawaran',
            'tanda_terima_barang_id',
            $this->integer()->null()->after('purchase_order_id')
        );
        $this->createIndex('idx_tanda_terima_di_mr_detail_penawaran',
            'material_requisition_detail_penawaran',
            'tanda_terima_barang_id'
        );

        $this->createTable('tanda_terima_barang_detail', [
            'id' => $this->primaryKey(),
            'material_requisition_detail_penawaran_id' => $this->integer(),
            'tanggal' => $this->date()->notNull(),
            'quantity_terima' => $this->decimal(10, 2)->notNull()
        ]);
        $this->createIndex('idx_mr_detail_penawaran_di_tanda_terima_barang_detail',
            'tanda_terima_barang_detail',
            'material_requisition_detail_penawaran_id'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex('idx_mr_detail_penawaran_di_tanda_terima_barang_detail', 'tanda_terima_barang_detail');
        $this->dropTable('tanda_terima_barang_detail');

        $this->dropIndex('idx_tanda_terima_di_mr_detail_penawaran', 'material_requisition_detail_penawaran');
        $this->dropColumn('material_requisition_detail_penawaran', 'tanda_terima_barang_id');

        $this->dropIndex('idx_card_acknowledge_di_tanda_terima_barang', 'tanda_terima_barang');
        $this->dropTable('tanda_terima_barang');
    }
}