<?php

namespace App\Dto\Movie;

class GetMovieDto
{
    public function __construct($id, $name, $casts, $releaseDate, $director, $ratings){
        $this->id = $id;
        $this->name = $name;
        $this->casts = $casts;
        $this->releaseDate = $releaseDate;
        $this->director = $director;
        $this->ratings = $ratings;
    }

    private $id;
    private $name;
    private $casts;
    private $releaseDate;
    private $director;
    public  $ratings;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getCasts()
    {
        return $this->casts;
    }

    /**
     * @return datetime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return string
     */
    public function getDirector()
    {
        return $this->director;
    }



}