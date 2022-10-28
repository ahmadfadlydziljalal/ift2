<?php

use yii\db\Migration;

/**
 * Class m221028_072426_AlterCardTable
 */
class m221028_072426_AlterCardTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('card', 'alamat', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('card', 'alamat');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221028_072426_AlterCardTable cannot be reverted.\n";

        return false;
    }
    */
}