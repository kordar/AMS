<?php

use yii\db\Migration;

class m171122_112812_api_status_code_group_order extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_status_code_group_order}}', [
            'orderID' => 'int(11) NOT NULL AUTO_INCREMENT',
            'projectID' => 'int(11) NOT NULL',
            'orderList' => 'text NOT NULL',
            'PRIMARY KEY (`orderID`,`projectID`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        
        /* 索引设置 */
        $this->createIndex('projectID','{{%api_status_code_group_order}}','projectID',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_status_code_group_order}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

