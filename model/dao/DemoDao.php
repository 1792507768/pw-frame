<?php
namespace pwframe\model\dao;

use pwframe\lib\frame\model\MySQLBase;

class DemoDao extends MySQLBase {

    public function tableName() {
        return 'demo';
    }
    
    public function collumnNames() {
        return [];
    }

}