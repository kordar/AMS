<?php

use yii\db\Migration;

class m171122_112812_api extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api}}', [
            'apiID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'apiName' => 'varchar(255) NOT NULL',
            'apiURI' => 'varchar(255) NOT NULL',
            'apiProtocol' => 'tinyint(1) unsigned NOT NULL',
            'apiFailureMock' => 'text NULL',
            'apiSuccessMock' => 'text NULL',
            'apiRequestType' => 'tinyint(1) unsigned NOT NULL',
            'apiSuccessMockType' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'apiFailureMockType' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'apiStatus' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'apiUpdateTime' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'groupID' => 'int(11) unsigned NOT NULL',
            'projectID' => 'int(11) unsigned NOT NULL',
            'starred' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'removed' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'removeTime' => 'timestamp NULL',
            'apiNoteType' => 'tinyint(1) unsigned NOT NULL DEFAULT \'0\'',
            'apiNoteRaw' => 'text NULL',
            'apiNote' => 'text NULL',
            'apiRequestParamType' => 'tinyint(3) unsigned NOT NULL DEFAULT \'0\'',
            'apiRequestRaw' => 'text NULL',
            'createdUserID' => 'int(11) NOT NULL DEFAULT \'0\'',
            'updateUserID' => 'int(11) NOT NULL DEFAULT \'0\'',
            'PRIMARY KEY (`apiID`,`apiURI`,`groupID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        $this->createIndex('groupID','{{%api}}','groupID',0);
        $this->createIndex('apiID','{{%api}}','apiID',0);
        $this->createIndex('projectID','{{%api}}','projectID',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

