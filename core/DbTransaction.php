<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/15
 * Time: 16:02
 */
class DbTransaction extends BaseSql
{
    protected $logic;

    function __construct($logic)
    {
        $this->logic = $logic;
    }

    public static function run($logic)
    {
        $instance = new self($logic);
        $instance->runTransaction();
    }

    function runTransaction()
    {}

    //断言
    function assertNotInTransaction()
    {
        $mysqli = BaseSql::getInstance();


    }
}