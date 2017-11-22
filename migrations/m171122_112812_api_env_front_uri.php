<?php

use yii\db\Migration;

class m171122_112812_api_env_front_uri extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_env_front_uri}}', [
            'envID' => 'int(10) unsigned NOT NULL',
            'uri' => 'varchar(255) NOT NULL',
            'uriID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'applyProtocol' => 'varchar(4) NOT NULL DEFAULT \'-1\'',
            'PRIMARY KEY (`envID`,`uriID`)'
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
        $this->dropTable('{{%api_env_front_uri}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

