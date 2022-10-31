<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%material_requisition}}`.
 */
class m221031_044433_CreateMaterialRequisitionTable extends Migration
{
    public string $table = '{{%material_requisition}}';
    public string $tableDetail = '{{%material_requisition_detail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'nomor' => $this->string(128),
            'vendor_id' => $this->integer()->notNull()->comment('Orang kantor'),
            'tanggal' => $this->date()->notNull(),
            'remarks' => $this->text()->null(),
            'approved_by' => $this->string()->notNull(),
            'acknowledge_by' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createTable($this->tableDetail, [
            'id' => $this->primaryKey(),
            'material_requisition_id' => $this->integer(),
            'tipe_pembelian_id' => $this->integer()->notNull(),
            'barang_id' => $this->integer(),
            'description' => $this->string(),
            'quantity' => $this->decimal(10, 2)->notNull(),
            'satuan_id' => $this->integer()->notNull(),
            'waktu_permintaan_terakhir' => $this->dateTime(),
            'harga_terakhir' => $this->decimal(12, 2),
            'stock_terakhir' => $this->decimal(10, 2),
        ]);

        $this->createIndex(
            'idx_material_requisition_vendor_id',
            $this->table,
            'vendor_id'
        );

        $this->createIndex(
            'idx_detail_material_requisition',
            $this->tableDetail,
            'material_requisition_id'
        );

        $this->createIndex(
            'idx_tipe_pembelian_detail_material_requisition',
            $this->tableDetail,
            'tipe_pembelian_id'
        );

        $this->createIndex(
            'idx_barang_detail_material_requisition',
            $this->tableDetail,
            'barang_id'
        );

        $this->createIndex(
            'idx_satuan_detail_material_requisition',
            $this->tableDetail,
            'satuan_id'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableDetail);
        $this->dropTable($this->table);
    }
}