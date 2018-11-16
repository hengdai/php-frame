<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2018/11/16
 * Time: 19:01
 */

class BaseResponse
{
    protected $data;
    protected $contentType = 'text/html';
    protected $charset = 'utf-8';
    protected $code = 200;
    protected $option = [];
    protected $header = [];
    protected $content = null;

    public function __construct ($data = '', $code = 200, array $header = [], array $option = [])
    {
        $this->data = $data;
        $this->code = $code;
        $this->option = array_merge($this->option, $option);
        $this->header = array_merge($this->header, $header);
        $this->header['Content-Type'] = $this->contentType . ";charset=" . $this.$this->charset;
    }

    public function JsonResponse ()
    {
//        $response = new static($this->data, $this->code, $this->header, $this->header);
        $response = [$this->data, $this->code, $this->header, $this->header];
        return $response;
    }
}