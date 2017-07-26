<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/7
 * Time: 17:36
 */

header("Content-type: text/html; charset=utf-8");

define('APP_PATH', __DIR__ . '/');

define('APP_DEBUG', true);

require(APP_PATH . 'core/Core.php');

$config = require(APP_PATH . 'config/config.php');

(new Core($config))->run();
