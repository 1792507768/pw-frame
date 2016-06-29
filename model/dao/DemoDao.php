<?php
namespace pwframe\model\dao;

use pwframe\lib\frame\model\MySQLBase;

class DemoDao extends MySQLBase {

    public function collumnNames() {
        return [];
    }

    public function databaseName()
    {
        return 'test';
    }

    public function tableName() {
        return 'demo';
    }

}