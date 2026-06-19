<?php

use yii\db\Migration;

class m260619_085201_AlterQuotationTable extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('quotation', 'created_at', $this->integer()->null());
        $this->addColumn('quotation', 'updated_at', $this->integer()->null());
        $this->addColumn('quotation', 'created_by', $this->integer()->null());
        $this->addColumn('quotation', 'updated_by', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('quotation', 'created_at');
        $this->dropColumn('quotation', 'updated_at');
        $this->dropColumn('quotation', 'created_by');
        $this->dropColumn('quotation', 'updated_by');
    }

}
