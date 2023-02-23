<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quotation_form_job_mekanik}}`.
 */
class m230222_222046_CreateQuotationFormJobMekanikTable extends Migration
{

   private string $table;

   public function init()
   {
      $this->table = '{{%quotation_form_job_mekanik}}';
      parent::init();
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->createTable($this->table, [
         'id' => $this->primaryKey(),
         'quotation_form_job_id' => $this->integer(),
         'mekanik_id' => $this->integer()->notNull()
      ]);

      $this->createIndex('idx_quotation_form_job', $this->table, 'quotation_form_job_id');
      $this->addForeignKey('fk_quotation_form_job', $this->table, 'quotation_form_job_id',
         'quotation_form_job',
         'id',
         'CASCADE',
         'CASCADE'
      );

      $this->createIndex('idx_mekanik_quotation_form_job', $this->table, 'mekanik_id');
      $this->addForeignKey('fk_mekanik_quotation_form_job', $this->table, 'mekanik_id',
         'card',
         'id',
         'RESTRICT',
         'CASCADE'
      );


   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_mekanik_quotation_form_job', $this->table);
      $this->dropForeignKey('fk_quotation_form_job', $this->table);
      $this->dropIndex('idx_quotation_form_job', $this->table);
      $this->dropIndex('idx_mekanik_quotation_form_job', $this->table);
      $this->dropTable('{{%quotation_form_job_mekanik}}');
   }
}