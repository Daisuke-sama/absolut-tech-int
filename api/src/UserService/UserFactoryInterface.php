<?php

namespace App\UserService;

use App\Entity\User;

interface UserFactoryInterface
{
    public function create(string $cell): User;
}
