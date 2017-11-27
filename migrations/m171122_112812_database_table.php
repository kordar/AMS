<?php

use yii\db\Migration;

class m171122_112812_database_table extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%database_table}}', [
            'dbID' => 'int(10) unsigned NOT NULL',
            'tableID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'tableName' => 'varchar(255) NOT NULL',
            'tableDescription' => 'varchar(255) NULL',
            'PRIMARY KEY (`tableID`, `dbID`)'
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
        $this->dropTable('{{%database_table}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

