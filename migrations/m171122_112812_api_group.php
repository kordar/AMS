<?php

use yii\db\Migration;

class m171122_112812_api_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_group}}', [
            'groupID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'groupName' => 'varchar(30) NOT NULL',
            'projectID' => 'int(11) unsigned NOT NULL',
            'parentGroupID' => 'int(10) unsigned NOT NULL DEFAULT \'0\'',
            'isChild' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\'',
            'PRIMARY KEY (`groupID`,`projectID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        $this->createIndex('groupID','{{%api_group}}','groupID',0);
        $this->createIndex('projectID','{{%api_group}}','projectID',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

