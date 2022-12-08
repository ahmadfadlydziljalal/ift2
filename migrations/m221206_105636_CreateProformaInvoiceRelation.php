<?php

use yii\db\Migration;

/**
 * Class m221206_105636_CreateProformaInvoiceRelation
 */
class m221206_105636_CreateProformaInvoiceRelation extends Migration
{

   private string $tableMaster = "{{%proforma_invoice}}";
   private string $tableDetailBarang = "{{%proforma_invoice_detail_barang}}";
   private string $tableDetailService = "{{%proforma_invoice_detail_service}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addForeignKey(
         'fk_quotation_id_di_proforma_invoice',
         $this->tableMaster,
         'quotation_id',
         'quotation',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_proforma_invoice_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang,
         'proforma_invoice_id',
         'proforma_invoice',
         'id',
         'CASCADE',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_barang_id_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang,
         'barang_id',
         'barang',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_satuan_id_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang,
         'satuan_id',
         'satuan',
         'id',
         'RESTRICT',
         'CASCADE'
      );
      $this->addForeignKey(
         'fk_proforma_invoice_id_di_proforma_invoice_detail_service',
         $this->tableDetailService,
         'proforma_invoice_id',
         'proforma_invoice',
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
         'fk_quotation_id_di_proforma_invoice',
         $this->tableMaster
      );
      $this->dropForeignKey(
         'fk_proforma_invoice_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_barang_id_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_satuan_id_di_proforma_invoice_detail_barang',
         $this->tableDetailBarang
      );
      $this->dropForeignKey(
         'fk_proforma_invoice_id_di_proforma_invoice_detail_service',
         $this->tableDetailService
      );
   }

}