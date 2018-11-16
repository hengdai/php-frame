<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/9
 * Time: 17:48
 */
class Log
{
    function __construct()
    {
        error_reporting(0);
        set_exception_handler('Log::debug');
        set_error_handler('Log::debug');
    }

    public static function debug($message = '', $info = [])
    {
        $log = [date('Y-m-d', time()).$message, $info];
        self::logToFile(json_encode($log)."\n");
    }

    protected static function logToFile($log)
    {
        $fileName = date('Y-m-d', time()).'.log';
        if (!file_exists('log/')) {
            mkdir('log');
        }
        $file = fopen('log/' . $fileName, 'a') or die('文件打开或者新建失败');
        fwrite($file, $log);
        fclose($file);
        exit('系统有误，请稍后再试！');
    }
}