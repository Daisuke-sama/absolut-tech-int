<?php

namespace App\Model;

class UserProfileModel extends AbstractModel
{
    public string $uuid;
    public bool $isConfirmed;
    public \DateTime $createdAt;
    public \DateTime $updatedAt;
}
