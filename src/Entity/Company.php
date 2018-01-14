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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $answer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $answeredAt;

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

    public function getAnswer(): ?bool
    {
        return $this->answer;
    }

    public function setAnswer(bool $answer)
    {
        if (null === $this->getAnswer()) {
            // Company can react Resume if company received it from aspirant
            if ($this->getResume()) {
                $this->answer = $answer;
                $this->setAnsweredAt(new \DateTime());
            }
        }
    }

    public function invite()
    {
        $this->setAnswer(true);
    }

    public function dismiss()
    {
        $this->setAnswer(false);
    }

    public function getAnsweredAt(): ?\DateTime
    {
        return $this->answeredAt;
    }

    public function setAnsweredAt($answeredAt)
    {
        $this->answeredAt = $answeredAt;
    }

    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    public function setResume(Resume $resume)
    {
        if ($this->resume == $resume) {
            return;
        }

        $this->resume = $resume;
        $resume->addCompany($this);
    }
}
