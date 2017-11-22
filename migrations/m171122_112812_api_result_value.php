<?php

use yii\db\Migration;

class m171122_112812_api_result_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_result_value}}', [
            'valueID' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'value' => 'text NOT NULL',
            'valueDescription' => 'varchar(255) NULL',
            'paramID' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`valueID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
        
        /* 索引设置 */
        $this->createIndex('resultParamID','{{%api_result_value}}','paramID',0);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_result_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

