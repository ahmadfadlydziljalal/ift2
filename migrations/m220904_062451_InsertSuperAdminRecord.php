<?php

use yii\db\Migration;

/**
 * Class m220904_062451_InsertSuperAdminRecord
 */
class m220904_062451_InsertSuperAdminRecord extends Migration
{

    public string $table = '{{user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
         * |  1 | Raya     | naPJnMalyVQKoXrM6x4fkYSMOkn4RZwc | $2y$13$6tx5TlsGZk9lPyqTI6VdpOcSkiBlWM.XZ1LH0cpUfieMK95cwUKeO | NULL                 | dzil@tresnamuda.co.id |     10 | 1662272642 | 1662272642 |

         * */
        $this->insert($this->table,[
            'id' => 1,
            'username' => 'Raya',
            'auth_key' => 'VcwkVbdWmExyRps4F-bBycHFQ36VB1JG ',
            'password_hash' => '$2y$13$u2AzxdDIps7DaxfXfAzrUub.yQZj18pykG1Z0TtGIXxonZ0twbxf2',
            'password_reset_token' => NULL,
            'email' => 'dzil@tresnamuda.co.id',
            'status' => 10,
            'created_at' => '1662272642',
            'updated_at' => '1662272642',
        ]);



        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

       return $this->delete($this->table,'id=1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220904_062451_InsertSuperAdminRecord cannot be reverted.\n";

        return false;
    }
    */
}