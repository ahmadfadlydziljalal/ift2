<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%card}}`.
 */
class m221101_074524_AddNpwpColumnToCardTable extends Migration
{

    public $db = 'db';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('card', 'npwp',
            $this->char(24)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('card', 'npwp');
    }
}