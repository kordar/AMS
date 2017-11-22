<?php

use yii\db\Migration;

class m171122_112812_api_env_param extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_env_param}}', [
            'paramID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'envID' => 'int(10) unsigned NOT NULL',
            'paramKey' => 'varchar(255) NOT NULL',
            'paramValue' => 'text NOT NULL',
            'PRIMARY KEY (`paramID`,`envID`)'
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
        $this->dropTable('{{%api_env_param}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

