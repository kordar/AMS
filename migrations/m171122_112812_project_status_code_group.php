<?php

use yii\db\Migration;

class m171122_112812_project_status_code_group extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%project_status_code_group}}', [
            'groupID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'projectID' => 'int(10) unsigned NOT NULL',
            'groupName' => 'varchar(255) NOT NULL',
            'parentGroupID' => 'int(10) unsigned NOT NULL DEFAULT \'0\'',
            'isChild' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\'',
            'PRIMARY KEY (`groupID`,`projectID`)'
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
        $this->dropTable('{{%project_status_code_group}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

