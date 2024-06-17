<?php

namespace App\Exceptions;


class TaskNotFoundException extends BaseCustomException
{
    protected $message = 'Task not found';
    protected $code = 404;

}
