<?php

namespace App\Dto\Movie;

use App\Dto\AbstractPostBaseDto;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class PostMovieDto extends AbstractPostBaseDto
{
    public function __construct($name, $casts, $releaseDate, $director, $ratings){
        $this->name = $name;
        $this->casts = $casts;
        $this->releaseDate = $releaseDate;
        $this->director = $director;
        $this->ratings = $ratings;
    }

    /**
     * @Assert\Type(type="string", message="Value {{ value }} must be string!")
     * @Assert\NotBlank(message="Value cannot be empty!")
     * @Assert\Length(min="1", max="100", minMessage="Value must be between 1 and 100 characters long!")
     */
    private $name;

    /**
     * @Assert\Type(type="array", message="Value {{ value }} must be array!")
     * @Assert\NotBlank(message="Value cannot be empty!")
     */
    private $casts;

    /**
     * @Assert\Regex(pattern = "((0[1-9]|[12]\d|3[01])-(0[1-9]|1[0-2])-[12]\d{3})", message="Date must be in d-m-YYYY format")
     */
    private $releaseDate;

    /**
     * @Assert\Type(type="string", message="Value {{ value }} must be string!")
     * @Assert\NotBlank(message="Value cannot be empty!")
     * @Assert\Length(min="1", max="100", minMessage="Value must be between 1 and 100 characters long!")
     */
    private $director;

    /**
     * @Assert\Type(type="array", message="Value {{ value }} must be array!")
     * @Assert\NotBlank(message="Value cannot be empty!")
     */
    public $ratings;


    public function getRatings()
    {
        return $this->ratings;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getCasts()
    {
        return $this->casts;
    }

    /**
     * @SerializedName("release_date")
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getDirector()
    {
        return $this->director;
    }
}