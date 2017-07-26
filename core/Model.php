<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 11:43
 */

class Model extends BaseSql
{
    protected $_model;
    protected $_table;
    public static $dbConfig = [];

    function __construct()
    {
        if (!$this->_table) {
            $this->_model = lcfirst(substr(get_class($this), 0, -5));
            $this->_table = $this->getTableName($this->_model);
        }

        return parent::__construct();
    }
}