<?php

use yii\db\Migration;

class m171122_112812_database extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%database}}', [
            'dbID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'dbName' => 'varchar(255) NOT NULL',
            'dbVersion' => 'float unsigned NOT NULL',
            'dbUpdateTime' => 'timestamp NOT NULL DEFAULT \'CURRENT_TIMESTAMP\'',
            'PRIMARY KEY (`dbID`)'
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
        $this->dropTable('{{%database}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

