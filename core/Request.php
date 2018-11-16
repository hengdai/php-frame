<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/10
 * Time: 15:14
 */
class Request
{
    public function get($key = '')
    {
        if ($key == '') {
            array_shift($_GET);
            return $_GET;
        } elseif (isset($_GET[$key])) {
            return $_GET[$key];
        } else {
            throw new Exception('the request key is dosn\'t exist!');
        }
    }

    public function post($key = '')
    {
        if ($key == '') {
            array_shift($_POST);
            return $_POST;
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            throw new Exception('the request key is dosn\'t exist!');
        }
    }
}