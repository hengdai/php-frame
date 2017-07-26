<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 15:21
 */

class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    public function render($viewRout = '', $data = [])
    {
        foreach ($data as $key => $value) {
            $this->_view->assign($key, $value);
        }

        $this->_view->render($viewRout);
    }
}