<?php

namespace App\Service;

use App\Dto\Movie\GetMovieDto;
use App\Dto\Movie\PostMovieDto;
use App\Dto\Movie\UpdateMovieDto;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    private MovieRepository $movieRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $entityManager)
    {
        $this->movieRepository = $movieRepository;
        $this->entityManager = $entityManager;
    }

    public function addMovie(PostMovieDto $postMovieDto): GetMovieDto
    {
        $movie = new Movie();
        $movie->setName($postMovieDto->getName());
        $movie->setCasts($postMovieDto->getCasts());
        $movie->setRatings($postMovieDto->getRatings());
        $movie->setReleaseDate(DateTime::createFromFormat('d-m-Y', $postMovieDto->getReleaseDate()));
        $movie->setDirector($postMovieDto->getDirector());
        $this->movieRepository->add($movie, true);
        return $this->MapMovieToGetMovieDto($movie);
    }

    public function updateMovie(UpdateMovieDto $updateMovieDto): ?GetMovieDto
    {

        $movie = $this->movieRepository->find($updateMovieDto->getId());
        if($movie==null){
            return null;
        }
        $movie->setName($updateMovieDto->getName());
        $movie->setCasts($updateMovieDto->getCasts());
        $movie->setRatings($updateMovieDto->getRatings());
        $movie->setReleaseDate(DateTime::createFromFormat('d-m-Y', $updateMovieDto->getReleaseDate()));
        $movie->setDirector($updateMovieDto->getDirector());
        $this->movieRepository->add($movie, true);
        return $this->MapMovieToGetMovieDto($movie);
    }

    public function getById($id): GetMovieDto
    {
        $movie = $this->movieRepository->find($id);
        return $this->MapMovieToGetMovieDto($movie);
    }

    private function mapMovieToGetMovieDto($movie): GetMovieDto
    {
        return new GetMovieDto($movie->getId(), $movie->getName(), $movie->getCasts(), $movie->getReleaseDate(), $movie->getDirector(), $movie->getRatings());
    }

    public function getAll()
    {
        $query = $this->entityManager->createQuery("SELECT NEW App\Dto\Movie\GetMovieDto(
        m.id, m.name,
        m.casts,
        m.release_date,
        m.director,
        m.ratings)
        FROM App\Entity\Movie m    
        ");
        return $query->getResult();
    }
}