<?php

use yii\db\Migration;

/**
 * Class m220919_070513_InsertMenuTable
 */
class m220919_070513_InsertMenuTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();
        $this->db->createCommand("TRUNCATE menu;")->execute();

        $sql = <<<SQL
INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
	(4, 'Permission', 32, '/admin/permission/index', NULL, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e20277065726d697373696f6e272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(11, 'Gii', 31, '/gii/default/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e2027676969272c202769636f6e27203d3e20276d61676963275d3b),
	(12, 'Debug', 31, '/debug/default/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e20276465627567272c202769636f6e27203d3e2027627567275d3b),
	(15, 'Top Menu', NULL, NULL, NULL, NULL),
	(16, 'Left Menu', NULL, NULL, NULL, NULL),
	(25, 'Contact', 15, '/site/contact', NULL, NULL),
	(26, 'Informasi Akun', 28, '/site/account-information', NULL, NULL),
	(28, 'Right Menu', NULL, NULL, NULL, NULL),
	(29, 'Tentang Web', 15, '/site/about', NULL, NULL),
	(31, 'Develop', 16, NULL, 10, _binary 0x72657475726e5b2769636f6e27203d3e202766696c652d636f6465275d3b),
	(32, 'Trustee', 16, NULL, 30, _binary 0x72657475726e5b2769636f6e27203d3e202766697265275d3b),
	(33, 'Beranda', 16, '/site/index', 0, _binary 0x72657475726e5b2769636f6e27203d3e2027686f757365275d3b),
	(34, 'Settings', 16, '/settings/default/index', 20, _binary 0x72657475726e5b276d6f64756c6527203d3e202773657474696e6773272c2027636f6e74726f6c6c657227203d3e202764656661756c74272c202769636f6e27203d3e202767656172275d3b),
	(35, 'Ganti Password', 28, '/site/change-password', NULL, NULL),
	(37, 'Utilities', 16, NULL, 40, _binary 0x72657475726e5b2769636f6e27203d3e202764706164275d3b),
	(38, 'User', 32, '/admin/user/index', NULL, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e202775736572272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(39, 'Rule', 32, '/admin/rule/index', NULL, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e202772756c65272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(40, 'Route', 32, '/admin/route/index', NULL, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e2027726f757465272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(41, 'Role', 32, '/admin/role/index', NULL, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e2027726f6c65272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(45, 'Cache', 37, '/cache/index', 0, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e20276361636865272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(46, 'Log', 37, '/log/index', 0, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e20276c6f67272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(47, 'Menu', 37, '/admin/menu/index', 40, _binary 0x72657475726e5b276d6f64756c6527203d3e202761646d696e272c2027636f6e74726f6c6c657227203d3e20276d656e75272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(48, 'Session', 37, '/session/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e202773657373696f6e272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(49, 'Faktur', 16, '/faktur/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e202766616b747572272c202769636f6e27203d3e202772656365697074275d3b),
	(50, 'Card', 16, '/card/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e202763617264272c202769636f6e27203d3e2027706572736f6e2d6261646765275d3b),
	(51, 'Barang', 16, '/barang/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e2027626172616e67272c202769636f6e27203d3e2027626f786573275d3b),
	(52, 'Satuan', 16, '/satuan/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e202773617475616e272c202769636f6e27203d3e202773636973736f7273275d3b),
	(53, 'Card Type', 16, '/card-type/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e2027636172642d74797065272c202769636f6e27203d3e2027706c61792d636972636c65275d3b),
	(54, 'Rekening', 16, '/rekening/index', NULL, _binary 0x72657475726e5b27636f6e74726f6c6c657227203d3e202772656b656e696e67272c202769636f6e27203d3e202762616e6b32275d3b);

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
        $this->db->createCommand("TRUNCATE menu;")->execute();
        $this->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220919_070513_InsertMenuTable cannot be reverted.\n";

        return false;
    }
    */
}