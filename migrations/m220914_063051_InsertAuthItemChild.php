<?php

use yii\db\Migration;

/**
 * Class m220914_063051_InsertAuthItemChild
 */
class m220914_063051_InsertAuthItemChild extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $sql = <<<SQL
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/assignment/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/assignment/assign');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/assignment/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/assignment/revoke');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/assignment/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/default/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/default/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/menu/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/assign');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/get-users');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/remove');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/permission/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/assign');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/get-users');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/remove');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/role/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/assign');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/refresh');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/route/remove');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/rule/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/activate');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/change-password');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/login');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/logout');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/request-password-reset');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/reset-password');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/signup');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/admin/user/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/dark-light-toggle/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/dark-light-toggle/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/db-explain');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/download-mail');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/toolbar');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/default/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/user/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/user/reset-identity');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/debug/user/set-identity');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/action');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/diff');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/preview');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/gii/default/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/item/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/delete');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/session/view');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/about');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/about');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/account-information');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/account-information');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/captcha');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/captcha');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/change-password');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/contact');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/contact');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/error');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/error');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/index');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/index');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/login');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/login');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/site/logout');
INSERT INTO auth_item_child (parent, child) VALUES ('user-default', '/site/logout');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/user/*');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/user/create');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/user/create-with-sihrd-integration');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/user/update');
INSERT INTO auth_item_child (parent, child) VALUES ('super-admin', '/user/update-with-sihrd-integration');

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
        $this->db->createCommand('TRUNCATE auth_item_child')->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220914_063051_InsertAuthItemChild cannot be reverted.\n";

        return false;
    }
    */
}