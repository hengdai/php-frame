<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2018/11/16
 * Time: 18:32
 */

class siteApi extends BaseApi
{
    public function index ()
    {
        return $this->success('hello world');
    }
}