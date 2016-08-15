<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="first_name")
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", name="last_name")
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", name="username", unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", name="email", unique=true, nullable=true)
     */
    protected $email;
}