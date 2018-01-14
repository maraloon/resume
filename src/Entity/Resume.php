<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResumeRepository")
 */
class Resume
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $position;

    /**
     * @ORM\Column(type="string")
     */
    private $text;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Company", mappedBy="resume",orphanRemoval=true, cascade={"persist"})
     */
    private $companies;

    private $invites;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position)
    {
        $this->position = $position;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getCompanies(): ?Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company)
    {
        if ($this->companies->contains($company)) {
            return;
        }

        $this->companies[] = $company;
        $company->setResume($this);
    }

    public function getInvites()
    {
        if ($this->invites === null) {
            $this->invites = $this->countInvites();
        }

        return $this->invites;
    }

    private function countInvites()
    {
        $invites = 0;

        foreach ($this->companies as $company) {
            if ($company->getAnswer()) {
                $invites++;
            }
        }

        return $invites;
    }
}
