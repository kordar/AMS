<?php

use yii\db\Migration;

class m171122_112812_conn_project extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%conn_project}}', [
            'connID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'projectID' => 'int(11) unsigned NOT NULL',
            'userID' => 'int(11) unsigned NOT NULL',
            'userType' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'inviteUserID' => 'int(11) NULL',
            'partnerNickName' => 'varchar(255) NULL',
            'PRIMARY KEY (`connID`,`projectID`,`userID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        $this->createIndex('projectID','{{%conn_project}}','projectID',0);
        $this->createIndex('eo_conn_ibfk_2','{{%conn_project}}','userID',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%conn_project}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

