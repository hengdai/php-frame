<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2018/11/16
 * Time: 18:45
 */

class BaseApi
{
    protected $request;

    public function __construct ()
    {
        $this->request = new Request();
    }

    protected function success ($data = '', $code = 1)
    {
        $result = [
            'code' => $code,
            'data' => $data
        ];

        echo json_encode($result);
    }
}