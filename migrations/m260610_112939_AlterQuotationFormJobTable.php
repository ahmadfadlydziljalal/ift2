<?php

use yii\db\Migration;

class m260610_112939_AlterQuotationFormJobTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_id', $this->integer()->null()->after('nomor'));
        $this->createIndex('surat_perintah_kerja_id_idx', '{{%quotation_form_job}}', 'surat_perintah_kerja_id');
        $this->addForeignKey('surat_perintah_kerja_id_fk', '{{%quotation_form_job}}', 'surat_perintah_kerja_id',
            '{{%surat_perintah_kerja}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_dos',
            $this->string()->null()->after('surat_perintah_kerja_id')
                ->comment('(Optional) Surat Perintah Kerja yang dibuat di DOS jika dibuat di situ')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey('surat_perintah_kerja_id_fk', '{{%quotation_form_job}}');
        $this->dropIndex('surat_perintah_kerja_id_idx', '{{%quotation_form_job}}');
        $this->dropColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_id');
        $this->dropColumn('{{%quotation_form_job}}', 'surat_perintah_kerja_dos');
    }


}
