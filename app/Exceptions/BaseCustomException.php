<?php

namespace App\Exceptions;

use Exception;

abstract class BaseCustomException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = null)
    {
        if($message) {
            $this->message = $message;
        }
        if($code) {
            $this->code = $code;
        }
        parent::__construct($this->message, $this->code);
    }
}
