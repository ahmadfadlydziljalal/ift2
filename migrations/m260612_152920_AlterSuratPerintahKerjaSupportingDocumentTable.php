<?php

use yii\db\Migration;

class m260612_152920_AlterSuratPerintahKerjaSupportingDocumentTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->dropForeignKey('fk-spk_quotation_id', '{{%surat_perintah_kerja_supporting_document}}');
        $this->dropIndex('idx-surat_perintah_kerja_quotation_id', '{{%surat_perintah_kerja_supporting_document}}');
        $this->createIndex('idx-surat_perintah_kerja_quotation_id', '{{%surat_perintah_kerja_supporting_document}}', 'quotation_id', true);
        $this->addForeignKey('fk-spk_quotation_id', '{{%surat_perintah_kerja_supporting_document}}', 'quotation_id', '{{%quotation}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {

        $this->dropForeignKey('fk-spk_quotation_id', '{{%surat_perintah_kerja_supporting_document}}');
        $this->dropIndex('idx-surat_perintah_kerja_quotation_id', '{{%surat_perintah_kerja_supporting_document}}');

        $this->createIndex('idx-surat_perintah_kerja_quotation_id', '{{%surat_perintah_kerja_supporting_document}}', 'quotation_id');
        $this->addForeignKey('fk-spk_quotation_id', '{{%surat_perintah_kerja_supporting_document}}', 'quotation_id', '{{%quotation}}', 'id', 'RESTRICT', 'CASCADE');
    }

}
