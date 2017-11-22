<?php

use yii\db\Migration;

class m171122_112812_api_env_header extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_env_header}}', [
            'headerID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'envID' => 'int(11) NOT NULL',
            'applyProtocol' => 'varchar(255) NULL',
            'headerName' => 'varchar(255) NOT NULL',
            'headerValue' => 'text NOT NULL',
            'PRIMARY KEY (`headerID`,`envID`)'
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
        $this->dropTable('{{%api_env_header}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

