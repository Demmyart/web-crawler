<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     *
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $restrictByUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRestrictByUrl(): ?string
    {
        return $this->restrictByUrl;
    }

    public function setRestrictByUrl(string $restrictByUrl): self
    {
        $this->restrictByUrl = $restrictByUrl;

        return $this;
    }
}
