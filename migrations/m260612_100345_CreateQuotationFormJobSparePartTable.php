<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_form_job_spare_part}}`.
 */
class m260612_100345_CreateQuotationFormJobSparePartTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('{{%quotation_form_job_spare_part}}', [
            'id'                    => $this->primaryKey(),
            'quotation_form_job_id' => $this->integer(),
            'barang_id'             => $this->integer()->notNull()->comment('Dalam konteks ini, barang disebut sebagai Spare Part'),
            'quantity'              => $this->decimal(10, 2)->notNull(),
            'satuan_id'             => $this->integer()->notNull(),
        ]);


        $this->createIndex('idx_quotation_form_job_spare_id', '{{%quotation_form_job_spare_part}}', 'quotation_form_job_id');
        $this->addForeignKey(
            'fk_quotation_form_job_spare_id',
            '{{%quotation_form_job_spare_part}}',
            'quotation_form_job_id',
            '{{%quotation_form_job}}',
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->createIndex('idx_quotation_form_job_spare_brg_id', '{{%quotation_form_job_spare_part}}', 'barang_id');
        $this->addForeignKey(
            'fk_quotation_form_job_spare_brg_id',
            '{{%quotation_form_job_spare_part}}',
            'barang_id',
            '{{%barang}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createIndex('idx_quotation_form_job_spare_satuan_id', '{{%quotation_form_job_spare_part}}', 'satuan_id');
        $this->addForeignKey(
            'fk_quotation_form_job_spare_satuan_id',
            '{{%quotation_form_job_spare_part}}',
            'satuan_id',
            '{{%satuan}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        $this->dropTable('{{%quotation_form_job_spare_part}}');
    }
}
