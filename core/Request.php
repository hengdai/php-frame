<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/10
 * Time: 15:14
 */
class Request
{
    public function get($key)
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }

        return '';
    }

    public function post($key)
    {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        return '';
    }
}