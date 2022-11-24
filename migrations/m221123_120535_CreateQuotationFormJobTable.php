<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_form_job}}`.
 */
class m221123_120535_CreateQuotationFormJobTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quotation_form_job}}', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(),
            'nomor' => $this->string()->null(),
            'tanggal' => $this->date()->notNull(),
            'person_in_charge' => $this->string()->comment('Perwakilan customer'),
            'issue' => $this->string()->null(),
            'card_own_equipment_id' => $this->integer()->null()->comment('Nomor Unit'),
            'hour_meter' => $this->string(),
            'mekanik_id' => $this->integer()->null()
        ]);

        $this->createIndex(
            "idx_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id"
        );

        $this->createIndex(
            "idx_card_own_equipment_di_quotation_form_job",
            "quotation_form_job",
            "card_own_equipment_id"
        );

        $this->createIndex(
            "idx_card_mekanik_di_quotation_form_job",
            "quotation_form_job",
            "mekanik_id"
        );

        $this->addForeignKey(
            "fk_quotation_di_quotation_form_job",
            "quotation_form_job",
            "quotation_id",
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            "fk_card_own_equipment_di_quotation_form_job",
            "quotation_form_job",
            "card_own_equipment_id",
            'card_own_equipment',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            "fk_card_mekanik_di_quotation_form_job",
            "quotation_form_job",
            "mekanik_id",
            'card',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->insert('card_type', [
            'id' => 5,
            'nama' => 'Mekanik',
            'kode' => 'mekanik'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('card_type', [
            'id' => 5,
            'nama' => 'Mekanik',
            'kode' => 'mekanik'
        ]);
        $this->dropTable('{{%quotation_form_job}}');
    }
}