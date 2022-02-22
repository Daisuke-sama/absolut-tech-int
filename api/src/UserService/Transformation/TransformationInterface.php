<?php

namespace App\UserService\Transformation;

use App\Entity\User;
use App\Model\AbstractModel;

interface TransformationInterface
{
    public function transform(User $user): AbstractModel;
}
