<?php

use yii\db\Migration;

class m171122_112812_api_cache extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_cache}}', [
            'cacheID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'projectID' => 'int(10) unsigned NOT NULL',
            'groupID' => 'int(10) unsigned NOT NULL',
            'apiID' => 'int(10) unsigned NOT NULL',
            'apiJson' => 'longtext NOT NULL',
            'starred' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\'',
            'updateUserID' => 'int(11) NOT NULL DEFAULT \'0\'',
            'PRIMARY KEY (`cacheID`)'
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
        $this->dropTable('{{%api_cache}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

