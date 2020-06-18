<?php

namespace App\Entity;

use \Datetime;

use App\Repository\UserRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateUpdated;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    //Getters & Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($val)
    {
        $this->id = $val;
    }

    /**
     * Get parent
     *
     * @return \App\Entity\User\firstName 
     */
    public function getFirstName() {
        return $this->firstName;
    }

    public function __toString(){
        return $this->getLastName();
        return $this->getFirstName();
        return $this->getEmail();
        return $this->getId();
    }

    public function setFirstName($firstName) 
    {
        $this->firstName=$firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName) 
    {
        $this->lastName=$lastName;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth) 
    {
        $this->dateOfBirth=$dateOfBirth;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email) 
    {
        $this->email=$email;
    }

    /**
     * Get published_at
     *
     * @return \DateTime 
     */
    public function getDateCreated(): ?DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) 
    {
        if($dateCreated instanceof \DateTime) {
            $this->dateCreated = $dateCreated;
        } else {
            $date = new \DateTime($dateCreated);
            $this->dateCreated = $date;
        }
    }

    public function getDateUpdated(): ?DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated($dateUpdated) 
    {
        $this->dateUpdated=$dateUpdated;
    }
}
