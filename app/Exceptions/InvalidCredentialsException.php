<?php

namespace App\Exceptions;

class InvalidCredentialsException extends BaseCustomException
{
    protected $message = 'Invalid credentials';
    protected $code = 401;
}
