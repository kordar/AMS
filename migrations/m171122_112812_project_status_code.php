<?php

use yii\db\Migration;

class m171122_112812_project_status_code extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%project_status_code}}', [
            'codeID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'code' => 'varchar(255) NOT NULL',
            'codeDescription' => 'varchar(255) NOT NULL',
            'groupID' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`codeID`)'
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
        $this->dropTable('{{%project_status_code}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

