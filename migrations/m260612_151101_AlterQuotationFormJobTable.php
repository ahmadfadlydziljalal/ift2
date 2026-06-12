<?php

use yii\db\Migration;

class m260612_151101_AlterQuotationFormJobTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->dropForeignKey('surat_perintah_kerja_id_fk', '{{%quotation_form_job}}');
        $this->dropIndex('surat_perintah_kerja_id_idx', '{{%quotation_form_job}}');
        $this->dropColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        
        $this->addColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_id', $this->integer()->null()->after('nomor'));
        $this->createIndex('surat_perintah_kerja_id_idx', '{{%quotation_form_job}}', 'surat_perintah_kerja_id');
        $this->addForeignKey('surat_perintah_kerja_id_fk', '{{%quotation_form_job}}', 'surat_perintah_kerja_id',
            '{{%surat_perintah_kerja}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

}
