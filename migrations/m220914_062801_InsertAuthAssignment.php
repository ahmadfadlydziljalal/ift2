<?php

use yii\db\Migration;

/**
 * Class m220914_062801_InsertAuthAssignment
 */
class m220914_062801_InsertAuthAssignment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $sql = <<<SQL
            INSERT INTO auth_assignment (item_name, user_id, created_at) VALUES ('super-admin', '1', 1662277046);
            # INSERT INTO auth_assignment (item_name, user_id, created_at) VALUES ('super-admin', '423', 1663766886);
SQL;

        $this->db->createCommand($sql)->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $this->db->createCommand('TRUNCATE auth_assignment')->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220914_062801_InsertAuthAssignment cannot be reverted.\n";

        return false;
    }
    */
}