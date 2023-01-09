<?php

use app\models\HistoryLokasiBarang;
use yii\db\Migration;

/**
 * Class m230109_071207_AlterHistoryLokasiBarangTable
 */
class m230109_071207_AlterHistoryLokasiBarangTable extends Migration
{
   protected string $table;
   protected array $columns;

   /**
    * @return void
    */
   public function init(): void
   {
      parent::init();
      $this->table = HistoryLokasiBarang::tableName();
      $this->columns = [
         'created_at' => $this->integer(11)->null()->defaultValue(null),
         'updated_at' => $this->integer(11)->null()->defaultValue(null),
         'created_by' => $this->string(10)->null()->defaultValue(null),
         'updated_by' => $this->string(10)->null()->defaultValue(null),
      ];
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      foreach ($this->columns as $key => $name) {
         $this->addColumn($this->table, $key, $name);
      }
   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $keys = array_keys($this->columns);
      foreach ($keys as $key) {
         $this->dropColumn($this->table, $key);
      }
   }

}