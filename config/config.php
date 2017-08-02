<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/7
 * Time: 18:10
 */
$data = [
    'db' => [
        'DB_HOST'=>'localhost',
        'DB_USER'=>'root',         //用户名
        'DB_PWD'=>'root',              //密码
        'DB_NAME'=>'phpframe',         //数据库名称
        'DB_PORT'=>'3306',         //端口号
        'DB_TYPE'=>'mysql',		   //数据库类型
        'DB_CHARSET'=>'utf-8',     //字符集
    ],
    'defaultConfig' => [
        'defaultController' => 'site',
        'defaultAction' => 'index',
    ],
];

return $data;