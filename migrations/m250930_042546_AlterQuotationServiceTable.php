<?php

use app\models\QuotationService;
use yii\db\Migration;

class m250930_042546_AlterQuotationServiceTable extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp(): void
    {
        $this->renameColumn('quotation_service', 'hours', 'quantity');
        $this->addColumn('quotation_service', 'satuan_id', $this->integer()->null()->after('quantity'));
        $this->renameColumn('quotation_service', 'rate_per_hour', 'rate');

        foreach (QuotationService::find()->each() as $quotationService) {
            $quotationService->satuan_id = 13;
            $quotationService->save(false);
            echo $quotationService->id . ' => ' . $quotationService->job_description . PHP_EOL;
        }

        $this->createIndex('idx_satuan_di_quotation_service', 'quotation_service', 'satuan_id');
        $this->addForeignKey('fk_satuan_di_quotation_service', 'quotation_service',
            'satuan_id',
            'satuan',
            'id',
            'RESTRICT',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {

        $this->dropForeignKey('fk_satuan_di_quotation_service', 'quotation_service');
        $this->dropIndex('idx_satuan_di_quotation_service', 'quotation_service');

        $this->renameColumn('quotation_service', 'rate', 'rate_per_hour');
        $this->dropColumn('quotation_service', 'satuan_id');
        $this->renameColumn('quotation_service', 'quantity', 'hours');

    }

}
