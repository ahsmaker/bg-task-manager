<?php

namespace App\Exceptions;


class ValidationException extends BaseCustomException
{
    protected $message = 'Validation failed';
    protected $code = 422;

}
