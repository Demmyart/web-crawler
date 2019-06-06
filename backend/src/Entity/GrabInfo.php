<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrabInfoRepository")
 */
class GrabInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $band;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Site")
     */
    private $sites;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $depth;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GrabResult", mappedBy="grabInfo", orphanRemoval=true)
     */
    private $grabResults;

    /**
     * @ORM\Column(type="integer")
     */
    private $finishedUrlsCounter;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->grabResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBand(): ?string
    {
        return $this->band;
    }

    public function setBand(?string $band): self
    {
        $this->band = $band;

        return $this;
    }

    /**
     * @return Collection|Site[]
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites[] = $site;
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->contains($site)) {
            $this->sites->removeElement($site);
        }

        return $this;
    }

    /**
     * @return Collection|GrabResult[]
     */
    public function getGrabResults(): Collection
    {
        return $this->grabResults;
    }

    public function addGrabResult(GrabResult $grabResult): self
    {
        if (!$this->grabResults->contains($grabResult)) {
            $this->grabResults[] = $grabResult;
            $grabResult->setGrabInfo($this);
        }

        return $this;
    }

    public function removeGrabResult(GrabResult $grabResult): self
    {
        if ($this->grabResults->contains($grabResult)) {
            $this->grabResults->removeElement($grabResult);
            // set the owning side to null (unless already changed)
            if ($grabResult->getGrabInfo() === $this) {
                $grabResult->setGrabInfo(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return GrabInfo
     */
    public function setDepth(int $depth): self
    {
        $this->depth = $depth;
        return $this;
    }

    public function getFinishedUrlsCounter(): ?int
    {
        return $this->finishedUrlsCounter;
    }

    public function setFinishedUrlsCounter(int $finishedUrlsCounter): self
    {
        $this->finishedUrlsCounter = $finishedUrlsCounter;

        return $this;
    }

    public function incrementFinishedCouter(): self
    {
        $this->finishedUrlsCounter++;

        return $this;
    }
}
