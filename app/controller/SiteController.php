<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 13:35
 */

class SiteController extends Controller
{
    public function index()
    {
//        $res = ZphUserModel::query()->findFirst();
//        print_r($res->company);
        $this->render('site/index', []);
    }
}