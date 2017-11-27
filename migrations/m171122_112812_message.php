<?php

use yii\db\Migration;

class m171122_112812_message extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%message}}', [
            'msgID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'toUserID' => 'int(10) unsigned NOT NULL',
            'fromUserID' => 'int(10) unsigned NOT NULL',
            'msgSendTime' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'msgType' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'summary' => 'varchar(255) NULL',
            'msg' => 'text NOT NULL',
            'isRead' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'otherMsg' => 'text NULL',
            'PRIMARY KEY (`msgID`)'
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
        $this->dropTable('{{%message}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

