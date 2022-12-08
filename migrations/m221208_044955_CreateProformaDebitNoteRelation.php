<?php

use yii\db\Migration;

/**
 * Class m221208_044955_CreateProformaDebitNoteRelation
 */
class m221208_044955_CreateProformaDebitNoteRelation extends Migration
{

   private string $tableMaster = '{{%proforma_debit_note}}';
   private string $tableDetailBarang = '{{%proforma_debit_note_detail_barang}}';
   private string $tableDetailService = '{{%proforma_debit_note_detail_service}}';

   public function safeUp()
   {
      $this->addForeignKey(
         'fk_quotation_id_di_proforma_debit_note',
         $this->tableMaster,
         'quotation_id',
         'quotation',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_proforma_debit_note_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'proforma_debit_note_id',
         'proforma_debit_note',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_barang_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'barang_id',
         'barang',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_satuan_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang,
         'satuan_id',
         'satuan',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_proforma_debit_note_id_di_proforma_debit_note_detail_service',
         $this->tableDetailService,
         'proforma_debit_note_id',
         'proforma_debit_note',
         'id',
         'CASCADE',
         'CASCADE'
      );
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey(
         'fk_quotation_id_di_proforma_debit_note',
         $this->tableMaster
      );
      $this->dropForeignKey(
         'fk_proforma_debit_note_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_barang_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_satuan_id_di_proforma_debit_note_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_proforma_debit_note_id_di_proforma_debit_note_detail_service',
         $this->tableDetailService
      );
   }

   /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m221208_044955_CreateProformaDebitNoteRelation cannot be reverted.\n";

       return false;
   }
   */
}