<?php

use yii\db\Migration;

class m171122_112812_api_test_history extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_test_history}}', [
            'testID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'apiID' => 'int(10) unsigned NOT NULL',
            'requestInfo' => 'longtext NULL',
            'resultInfo' => 'longtext NULL',
            'testTime' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'projectID' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`testID`)'
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
        $this->dropTable('{{%api_test_history}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

