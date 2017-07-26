<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 11:20
 */

class Core
{
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function run()
    {
        spl_autoload_extensions('.php');
        spl_autoload_register([$this, 'frameAutoload']);
        $this->setExceptionLog();
        $this->setLogStatus();
        $this->rout();
    }

    public function setExceptionLog()
    {
        new Log();
    }

    static public function frameAutoload($class)
    {
        $corePatch = APP_PATH . 'core/' . $class . '.php';
        $modelPath = APP_PATH . 'app/model/' . $class . '.php';
        $controllerPath = APP_PATH . 'app/controller/' . $class . '.php';;

        if (file_exists($modelPath)) {
            include($modelPath);
        } elseif (file_exists($corePatch)) {
            include($corePatch);
        } elseif (file_exists($controllerPath)) {
            include($controllerPath);
        }
    }

    public function setLogStatus()
    {
        if (APP_DEBUG == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
            ini_set('display_warning', 'off');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'off');
            ini_set('log_errors', 'On');
        }
    }

    public function rout()
    {
        $controllerName = ucfirst($this->config['defaultConfig']['defaultController']);
        $actionName = $this->config['defaultConfig']['defaultAction'];
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');
        $params = [];

        if ($position !== false) {
            $url = substr($url , 0 , $position);
        }
        $url = trim($url, '/');

        if ($url) {
            $urlArr = explode('/', $url);
            $controllerName = ucfirst(isset($urlArr[0]) ? $urlArr[0] : $controllerName);

            array_shift($urlArr);
            $actionName = isset($urlArr[0]) ? $urlArr[0] : $actionName;

            array_shift($urlArr);
            $params = isset($urlArr[0]) ? $urlArr[0] : [];
        }

        $controller = $controllerName . 'Controller';

        if (!class_exists($controller)) {
            exit($controller . ' dosn\'t exist！');
        }

        if (!method_exists($controller, $actionName)) {
            exit($actionName . ' dosn\'t exist！！');
        }

        $dispatch = new $controller($controllerName, $actionName);
        $dispatch->$actionName($params);
    }
}