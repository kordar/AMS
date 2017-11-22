<?php

use yii\db\Migration;

class m171122_112812_api_result_param extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_result_param}}', [
            'paramID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'paramName' => 'varchar(255) NULL',
            'paramKey' => 'varchar(255) NOT NULL',
            'apiID' => 'int(11) unsigned NOT NULL',
            'paramNotNull' => 'tinyint(1) unsigned NOT NULL',
            'PRIMARY KEY (`paramID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        $this->createIndex('apiID','{{%api_result_param}}','apiID',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_result_param}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

