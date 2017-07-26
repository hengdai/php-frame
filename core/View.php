<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 16:34
 */

class View
{
    protected $variables = [];
    protected $_controller;
    protected $_action;

    function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function render($viewRout = '')
    {
        include APP_PATH . 'app/view/template/header.php';
        extract($this->variables);

        if (!empty($viewRout)) {
            $routArr = explode('/', $viewRout);
            $path = $routArr[0];
            $file = $routArr[1];
        }

        $filePath = APP_PATH . 'app/view/' .$path. '/' . $file . '.php';

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            exit('file not exist!');
        }
    }
}