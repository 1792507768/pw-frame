<?php
namespace pwframe\model\dao;

use pwframe\lib\frame\mvc\MySQLBase;
use pwframe\lib\frame\ioc\BeanPrototype;

class DemoDao extends MySQLBase implements BeanPrototype {

    public function tableName() {
        return $this->tablePrefix().'demo';
    }
    
    public function collumnNames() {
        return [
            'id' => [], // 主键
            'parent_id' => [], // 父级
            'name' => [], // 名称
            'status' => [], // 状态
        ];
    }

    public function createTable() {
        return null !== $this->execSql(<<<ETO
CREATE TABLE `{$this->tablePrefix()}demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ETO
        );
    }
    
}