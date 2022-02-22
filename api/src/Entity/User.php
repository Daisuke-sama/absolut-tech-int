<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @method string getUserIdentifier()
 */
class User implements \JsonSerializable, UserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * note: the length is set just approx.
     *
     * @ORM\Column(type="string", length=20)
     */
    private $cell;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apiToken;

    /**
     * @ORM\Column(type="uuid", nullable=true)
     */
    private $uuid;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getCell(): ?string
    {
        return $this->cell;
    }

    public function setCell(string $cell): self
    {
        $this->cell = $cell;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'       => $this->id,
            'apiToken' => $this->apiToken,
        ];
    }

    public function getRoles()
    {
        return [];
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->cell;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
