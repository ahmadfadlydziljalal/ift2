<?php

use yii\db\Migration;

/**
 * Class m220914_062930_InsertAuthItem
 */
class m220914_062930_InsertAuthItem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $sql = <<<SQL
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/*', 2, null, null, null, 1662276433, 1662276433);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/assignment/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/assignment/assign', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/assignment/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/assignment/revoke', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/assignment/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/default/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/default/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/menu/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/assign', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/get-users', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/remove', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/permission/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/assign', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/get-users', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/remove', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/role/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/assign', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/refresh', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/route/remove', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/rule/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/activate', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/change-password', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/login', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/logout', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/request-password-reset', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/reset-password', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/signup', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/admin/user/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/dark-light-toggle/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/dark-light-toggle/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/db-explain', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/download-mail', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/toolbar', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/default/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/user/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/user/reset-identity', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/debug/user/set-identity', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/action', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/diff', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/preview', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/gii/default/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/*', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/create', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/delete', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/index', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/update', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/item/view', 2, null, null, null, 1662972733, 1662972733);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/delete', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/session/view', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/*', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/*', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/create', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/delete', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/index', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/toggle', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/update', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/settings/default/view', 2, null, null, null, 1663658205, 1663658205);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/about', 2, null, null, null, 1662937535, 1662937535);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/account-information', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/captcha', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/change-password', 2, null, null, null, 1663663060, 1663663060);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/contact', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/error', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/index', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/login', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/site/logout', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/user/*', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/user/create', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/user/create-with-sihrd-integration', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/user/update', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('/user/update-with-sihrd-integration', 2, null, null, null, 1662784979, 1662784979);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('super-admin', 1, null, null, null, 1662277025, 1662549609);
INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('user-default', 1, null, null, null, 1663663252, 1663663252);

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
        $this->db->createCommand('TRUNCATE auth_item')->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220914_062930_InsertAuthItem cannot be reverted.\n";

        return false;
    }
    */
}