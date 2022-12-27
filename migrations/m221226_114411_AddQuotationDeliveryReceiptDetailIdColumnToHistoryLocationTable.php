<?php

use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceiptDetail;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%history_location}}`.
 */
class m221226_114411_AddQuotationDeliveryReceiptDetailIdColumnToHistoryLocationTable extends Migration
{

   public string $table;

   public function init()
   {
      parent::init();
      $this->table = HistoryLokasiBarang::tableName();
   }

   /**
    * {@inheritdoc}
    */
   public function safeUp()
   {
      $this->addColumn($this->table, 'quotation_delivery_receipt_detail_id', $this->integer()->null()->after('claim_petty_cash_nota_detail_id'));
      $this->createIndex('idx_quotation_delivery_receipt_detail_di_history_Location', $this->table, 'quotation_delivery_receipt_detail_id');
      $this->addForeignKey('fk_quotation_delivery_receipt_detail_di_history_Location',
         $this->table,
         'quotation_delivery_receipt_detail_id',
         QuotationDeliveryReceiptDetail::tableName(),
         'id',
         'CASCADE',
         'CASCADE',
      );

   }

   /**
    * {@inheritdoc}
    */
   public function safeDown()
   {
      $this->dropForeignKey('fk_quotation_delivery_receipt_detail_di_history_Location', $this->table);
      $this->dropIndex('idx_quotation_delivery_receipt_detail_di_history_Location', $this->table);
      $this->dropColumn($this->table, 'quotation_delivery_receipt_detail_id');
   }
}