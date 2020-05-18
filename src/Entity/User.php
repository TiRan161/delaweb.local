<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="LAZY")
     * @ORM\JoinColumn(name="invited_by", nullable=false)
     */
    private $invited;

    /**
     * @var Organisation
     *
     * @ORM\ManyToOne(targetEntity="Organisation", fetch="LAZY", inversedBy="users")
     * @ORM\JoinColumn(name="organisation_id", nullable=false)
     */
    private $organisation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname(string $surname): User
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function setPhone(string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return User
     */
    public function getInvited(): User
    {
        return $this->invited;
    }

    /**
     * @param User $invited
     * @return User
     */
    public function setInvited(User $invited): User
    {
        $this->invited = $invited;
        return $this;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }

    /**
     * @param Organisation $organisation
     * @return User
     */
    public function setOrganisation(Organisation $organisation): User
    {
        $this->organisation = $organisation;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getPhone();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}
