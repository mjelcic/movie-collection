<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie extends AbstractBaseEntity
{

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="array")
     */
    private array $casts = [];

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $release_date;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $director;

    /**
     * @ORM\Column(type="array")
     */
    private array $ratings = [];



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCasts(): ?array
    {
        return $this->casts;
    }

    public function setCasts(array $casts): self
    {
        $this->casts = $casts;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getRatings(): ?array
    {
        return $this->ratings;
    }

    public function setRatings(array $ratings): self
    {
        $this->ratings = $ratings;

        return $this;
    }

}
