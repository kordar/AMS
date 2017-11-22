<?php

use yii\db\Migration;

class m171122_112812_database_table_field extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%database_table_field}}', [
            'fieldID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'fieldName' => 'varchar(255) NOT NULL',
            'fieldType' => 'varchar(10) NOT NULL',
            'fieldLength' => 'varchar(10) NOT NULL',
            'isNotNull' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'isPrimaryKey' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'fieldDescription' => 'varchar(255) NULL',
            'tableID' => 'int(10) unsigned NOT NULL',
            'defaultValue' => 'varchar(255) NULL',
            'PRIMARY KEY (`fieldID`)'
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
        $this->dropTable('{{%database_table_field}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

