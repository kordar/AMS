<?php

use yii\db\Migration;

class m171122_112812_project_environment extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%project_environment}}', [
            'envID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'envName' => 'varchar(255) NOT NULL',
            'envURI' => 'varchar(255) NOT NULL',
            'projectID' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`envID`)'
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
        $this->dropTable('{{%project_environment}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

