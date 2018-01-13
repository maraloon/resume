<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $site;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNum;

    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="companies")
     */
    private $resume;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site)
    {
        $this->site = $site;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phoneNum;
    }

    public function setPhoneNum(string $phoneNum)
    {
        $this->phoneNum = $phoneNum;
    }

    public function getReaction(): ?bool
    {
        return $this->reaction;
    }

    public function setReaction(bool $reaction)
    {
        if (null === $this->getReaction()){
            // todo add $this->resume and check for $this->resume !== null
            // in other words, Company can react Resume if company received it from aspirant
            $this->reaction = $reaction;
        }
    }

    public function invite()
    {
        $this->setReaction(true);
    }

    public function dismiss()
    {
        $this->setReaction(false);
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(Resume $resume)
    {
        $this->resume = $resume;
    }
}
