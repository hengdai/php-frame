<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/9
 * Time: 9:39
 */

class ZphUserModel extends Model
{
    function __construct()
    {
        parent::init('id');
        return parent::__construct();;
    }

    public static function query()
    {
        $obj = new self();
        $obj->initSelect();
        return $obj;
    }
}