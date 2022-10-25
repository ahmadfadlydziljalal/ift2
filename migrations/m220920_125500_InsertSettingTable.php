<?php

use yii\db\Migration;

/**
 * Class m220920_125500_InsertSettingTable
 */
class m220920_125500_InsertSettingTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $this->db->createCommand("TRUNCATE settings")->execute();
        $sql = <<<SQL
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (1, 'string', 'site', 'name', 'TMS Starter', 1, '2022-09-20 19:38:11', null);
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (2, 'string', 'site', 'description', 'Web App dengan Management User, Role Based User Authentication, serta Module Settings. <br/> <br/> Cukup sediakan sebuah komputer dengan <strong>Docker Engine</strong> terpasang dengan baik, maka sistem ini bisa langsung dikembangkan sesuai dengan analisa dan peruntukan proses bisnis Anda. ', 1, '2022-09-20 19:42:02', '2022-09-24 12:36:01');
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (3, 'string', 'site', 'icon', '<i class="bi bi-airplane-engines"></i>', 1, '2022-09-20 19:43:22', '2022-09-20 19:44:11');
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (4, 'string', 'site', 'maintainer', 'Fadly Dzil', 1, '2022-09-20 19:44:51', '2022-09-20 19:45:10');
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (5, 'string', 'site', 'companyClient', 'Client Saya', 1, '2022-09-20 19:47:05', null);
INSERT INTO settings (id, type, section, `key`, value, active, created, modified) VALUES (6, 'string', 'site', 'maintainerCompany', 'Perusahaan Saya', 1, '2022-09-20 19:47:33', null);

SQL;
        $this->db->createCommand($sql)->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = <<<SQL
DELETE FROM `settings`;
SQL;
        $this->db->createCommand($sql)->execute();
    }

}