<?php

use yii\db\Migration;

/**
 * Class m220905_090313_AlterUserTable
 */
class m220905_090313_AlterUserTable extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'karyawan_id', $this->integer()->null());
        /*$this->insert('user',[
            'id' => '',
            'username' => '',
            'auth_key' => '',
            'password_hash' => '',
            'password_reset_token' => NULL,
            'email' => '',
            'status' => 10,
            'created_at' => '',
            'updated_at' => '',
            'karyawan_id' => ''
        ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->delete('user', 'id=:id', [':id' => '']);
        $this->dropColumn('user', 'karyawan_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220905_090313_AlterUserTable cannot be reverted.\n";

        return false;
    }
    */
}