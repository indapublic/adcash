<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Users.
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @var guid
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @Groups({"default"})
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Groups({"default"})
     *
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return parent::getUsername();
    }
}