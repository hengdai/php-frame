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
//        new BaseSql();
//        $pdo = BaseSql::getPdoInstance();
//        $notOrm = new NotORM($pdo);
//        $result = $notOrm->zph_user()->limit(10);
//        foreach ($result as $value) {
//            print_r($value['username']);
//        }
        $this->render('site/index', []);
    }
}