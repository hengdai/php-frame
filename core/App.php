<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/10
 * Time: 15:13
 */
class App
{
    public $request;

    function __construct()
    {
        $this->request = new Request();
    }

    public static function app()
    {
        return new self();
    }
}