<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class AuthResultCollection extends Collection
{
    public string $access_token;
    public string $token_type;
}