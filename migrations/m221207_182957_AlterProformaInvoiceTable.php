<?php

use yii\db\Migration;

/**
 * Class m221207_182957_AlterProformaInvoiceTable
 */
class m221207_182957_AlterProformaInvoiceTable extends Migration
{

   private string $table = "{{%proforma_invoice}}";

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn('proforma_invoice', 'pph_23_percent',
         $this->smallInteger()->defaultValue(0));
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropColumn('proforma_invoice', 'pph_23_percent');
   }

}