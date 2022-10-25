<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rekening}}`.
 */
class m221020_053907_CreateRekeningTable extends Migration
{

    private string $table = '{{%rekening}}';
    private string $tableDetail = '{{%rekening_detail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'atas_nama' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->null()->defaultValue(null),
            'updated_at' => $this->integer(11)->null()->defaultValue(null),
            'created_by' => $this->string(10)->null()->defaultValue(null),
            'updated_by' => $this->string(10)->null()->defaultValue(null),
        ]);

        $this->createTable($this->tableDetail,[
            'id' => $this->primaryKey(),
            'rekening_id' => $this->integer(),
            'bank' => $this->string()->notNull(),
            'nomor_rekening' => $this->string()->notNull()
        ]);

        $this->createIndex('idx_rekening_id_di_rekening_detail',
            'rekening_detail',
            'rekening_id'
        );
        $this->addForeignKey('fk_rekening_id_di_rekening_detail',
            'rekening_detail',
            'rekening_id',
            'rekening',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->batchInsert($this->table,
            ['id', 'atas_nama'],
            [
                [1 , 'Supriyanto'],
                [2 , 'Dicky']
            ]
        );

        $this->batchInsert($this->tableDetail,
            ['id', 'rekening_id', 'bank', 'nomor_rekening'],
            [
                [1, 1, 'BCA', '4281 4065 52'],
                [2, 1, 'BNI', '0335 6020 74'],
                [3, 2, 'BCA', '362 0433 666' ]
            ]
        );

        $this->addColumn('faktur', 'rekening_id', $this->integer()->null());
        $this->update('faktur', ['rekening_id' => 1], [
            'rekening_id' => null
        ]);
        $this->createIndex('idx_rekening_faktur', 'faktur', 'rekening_id' );
        $this->addForeignKey('fk_rekening_faktur',
            'faktur',
            'rekening_id',
            'rekening',
            'id',
            'RESTRICT',
            'CASCADE',
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_rekening_faktur', 'faktur');
        $this->dropIndex('idx_rekening_faktur', 'faktur');
        $this->dropColumn('faktur', 'rekening_id');

        $this->dropForeignKey('fk_rekening_id_di_rekening_detail', 'rekening_detail');
        $this->dropIndex('idx_rekening_id_di_rekening_detail', 'rekening_detail');
        $this->dropTable($this->tableDetail);
        $this->dropTable($this->table);
    }
}