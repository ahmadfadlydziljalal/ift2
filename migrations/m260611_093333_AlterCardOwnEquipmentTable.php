<?php

use yii\db\Migration;

class m260611_093333_AlterCardOwnEquipmentTable extends Migration {

    public string $tableName = "card_own_equipment";

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void {
        $this->addColumn($this->tableName, 'merk', $this->string()->after('card_id')->null());
        $this->addColumn($this->tableName, 'nomor_unit', $this->string()->after('nama')->null());
        $this->addCommentOnColumn($this->tableName, 'serial_number', "Nomor Produksi");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void {
        $this->dropColumn($this->tableName, 'merk');
        $this->dropColumn($this->tableName, 'nomor_unit');
        $this->dropCommentFromColumn($this->tableName, 'serial_number');
    }


}
