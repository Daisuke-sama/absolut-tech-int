<?php

namespace App\UserService\Transformation;

use App\Entity\User;
use App\Model\UserProfileModel;

class ProfileViewCreator implements TransformationInterface
{
    public function transform(User $user): UserProfileModel
    {
        $model              = new UserProfileModel();
        $model->uuid        = $user->getUuid();
        $model->isConfirmed = $user->getIsConfirmed();
        $model->updatedAt   = $user->getUpdatedAt();
        $model->createdAt   = $user->getCreatedAt();

        return $model;
    }
}
