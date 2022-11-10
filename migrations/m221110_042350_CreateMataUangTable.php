<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mata_uang}}`.
 */
class m221110_042350_CreateMataUangTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mata_uang}}', [
            'id' => $this->primaryKey(),
            'negara' => $this->string(),
            'nama' => $this->string()->unique()->comment('eg, Rupiah, Dollar Amerika, Dollar Singapore'),
            'kode' => $this->char(16)->comment('eg. IDR, USD'),
            'singkatan' => $this->char(16)->comment('eg. `Rp.` , USD. ')
        ]);

        $this->batchInsert('{{%mata_uang}}', ['negara', 'nama', 'kode', 'singkatan'], [
            ['Indonesia', 'Rupiah', 'IDR', 'Rp.'],
            ['The United States Of America', 'Dollar Amerika', 'USD', 'USD']
        ]);

        $this->addColumn('material_requisition_detail_penawaran', 'mata_uang_id',
            $this->integer()
                ->notNull()
                ->defaultValue(1)
                ->after('vendor_id')
        );

        $this->createIndex('idx_mata_uang_di_mr_detail_penawaran', 'material_requisition_detail_penawaran', 'mata_uang_id');
        $this->addForeignKey(
            'fk_mata_uang_di_mr_detail_penawaran',
            'material_requisition_detail_penawaran',
            'mata_uang_id',
            'mata_uang',
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

        $this->dropForeignKey('fk_mata_uang_di_mr_detail_penawaran', 'material_requisition_detail_penawaran');
        $this->dropIndex('idx_mata_uang_di_mr_detail_penawaran', 'material_requisition_detail_penawaran');
        $this->dropColumn('material_requisition_detail_penawaran', 'mata_uang_id');
        $this->dropTable('{{%mata_uang}}');
    }
}