<?php

namespace App\Exceptions;

class TaskCategoryNotFoundException extends BaseCustomException
{
    protected $message = 'Task Category not found';
    protected $code = 404;
}
