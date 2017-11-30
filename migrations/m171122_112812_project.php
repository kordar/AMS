<?php

use yii\db\Migration;

class m171122_112812_project extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%project}}', [
            'projectID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'projectType' => 'tinyint(1) unsigned NOT NULL',
            'projectName' => 'varchar(30) NOT NULL',
            'projectUpdateTime' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'projectVersion' => 'varchar(6) NOT NULL DEFAULT \'1.0\'',
            'status' => 'tinyint(1) NOT NULL DEFAULT 1',
            'created_user' => 'int(11) NOT NULL DEFAULT 0',
            'PRIMARY KEY (`projectID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%project}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

