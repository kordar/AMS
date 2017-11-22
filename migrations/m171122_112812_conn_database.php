<?php

use yii\db\Migration;

class m171122_112812_conn_database extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%conn_database}}', [
            'connID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'dbID' => 'int(10) unsigned NOT NULL',
            'userID' => 'int(10) unsigned NOT NULL',
            'userType' => 'tinyint(1) NOT NULL DEFAULT \'0\'',
            'inviteUserID' => 'int(10) NULL',
            'partnerNickName' => 'varchar(255) NULL',
            'PRIMARY KEY (`connID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%conn_database}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

