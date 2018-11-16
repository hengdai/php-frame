<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2018/11/16
 * Time: 17:30
 */

class UserController extends BaseController
{
    public function index ()
    {
        $this->render('site/index', []);
    }
}