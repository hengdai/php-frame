<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 13:35
 */

class SiteController extends BaseController
{
    public function index()
    {
//        $zphUser = ZphUserModel::query()->findByPk(1);
//        print_r($zphUser->company);
        $this->render('site/index', []);
    }
}