<?php

/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/12
 * Time: 16:33
 */
class Exceptions extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $e = parent::__construct($message, $code, $previous);

        $this->exceptionHandle($message, $e);
    }

    public function exceptionHandle($message, $exception)
    {
        Log::debug($message, [$exception]);
    }
}