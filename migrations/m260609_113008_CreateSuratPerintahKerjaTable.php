<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%surat_perintah_kerja}}`.
 */
class m260609_113008_CreateSuratPerintahKerjaTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->createTable('{{%surat_perintah_kerja}}', [
            'id'                     => $this->primaryKey(),
            'nomor'                  => $this->string(),
            'tanggal'                => $this->date()->notNull(),
            'pelaksana'              => $this->string()->notNull(),
            'judul'                  => $this->string()->notNull(),
            'keterangan'             => $this->text()->notNull()->comment("Deksripsi Pekerjaan Secara Umum"),
            'data_pendukung_lainnya' => $this->text()->null()->comment("Data Pendukung Lainnya, Contoh: Customer P.O, Email Direksi, dll"),
        ]);

        $this->createTable('{{%surat_perintah_kerja_supporting_document}}', [
            'id'                      => $this->primaryKey(),
            'surat_perintah_kerja_id' => $this->integer(),
            'quotation_id'            => $this->integer(),
        ]);
        $this->createIndex(
            'idx-surat_perintah_kerja_id',
            '{{%surat_perintah_kerja_supporting_document}}',
            'surat_perintah_kerja_id'
        );
        $this->createIndex(
            'idx-surat_perintah_kerja_quotation_id',
            '{{%surat_perintah_kerja_supporting_document}}',
            'quotation_id'
        );
        $this->addForeignKey(
            'fk-spk_supporting_document-surat_perintah_kerja_id',
            '{{%surat_perintah_kerja_supporting_document}}',
            'surat_perintah_kerja_id',
            '{{%surat_perintah_kerja}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-spk_quotation_id',
            '{{%surat_perintah_kerja_supporting_document}}',
            'quotation_id',
            '{{%quotation}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->createTable('{{%surat_perintah_kerja_detail}}', [
            'id'                      => $this->primaryKey(),
            'surat_perintah_kerja_id' => $this->integer(),
            'waktu'                   => $this->dateTime()->notNull(),
            'keterangan'              => $this->text()->notNull(),
        ]);
        $this->createIndex('idx-surat_perintah_kerja_detail-waktu', 'surat_perintah_kerja_detail', 'surat_perintah_kerja_id');
        $this->addForeignKey(
            'fk-spk_supporting_detail-waktu',
            '{{%surat_perintah_kerja_detail}}',
            'surat_perintah_kerja_id',
            '{{%surat_perintah_kerja}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        $this->dropTable('{{%surat_perintah_kerja_detail}}');
        $this->dropTable('{{%surat_perintah_kerja_supporting_document}}');
        $this->dropTable('{{%surat_perintah_kerja}}');
    }
}
