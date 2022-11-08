<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%status}}`.
 */
class m221107_093701_CreateStatusTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'section' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->string()->notNull()
        ]);

        $this->batchInsert('{{%status}}', ['id', 'section', 'key', 'value'], [
            [1, 'material-requisition-detail-penawaran-status', 'Pengajuan', '0'],
            [2, 'material-requisition-detail-penawaran-status', 'Ditolak', '10'],
            [3, 'material-requisition-detail-penawaran-status', 'Diterima', '20'],
        ]);

        $this->createIndex(
            'idx_status_di_penawaran',
            'material_requisition_detail_penawaran',
            'status_id'
        );
        $this->addForeignKey(
            'fk_status_di_penawaran',
            'material_requisition_detail_penawaran',
            'status_id',
            'status',
            'id',
            'RESTRICT',
            'CASCADE',
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk_status_di_penawaran',
            'material_requisition_detail_penawaran'
        );
        
        $this->dropIndex(
            'idx_status_di_penawaran',
            'material_requisition_detail_penawaran'
        );

        $this->dropTable('{{%status}}');
    }
}