<?php

namespace App\Service;

use App\Dto\Movie\GetMovieDto;
use App\Dto\Movie\PostMovieDto;
use App\Dto\Movie\UpdateMovieDto;
use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class MovieService
{
    private MovieRepository $movieRepository;
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $entityManager, Security $security)
    {
        $this->movieRepository = $movieRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function addMovie(PostMovieDto $postMovieDto): GetMovieDto
    {
        $movie = new Movie();
        $movie->setName($postMovieDto->getName());
        $movie->setCasts($postMovieDto->getCasts());
        $movie->setRatings($postMovieDto->getRatings());
        $movie->setCreatedBy($this->getUserId() ? $this->getUserId() : 0);
        $movie->setReleaseDate(DateTime::createFromFormat('d-m-Y', $postMovieDto->getReleaseDate()));
        $movie->setDirector($postMovieDto->getDirector());
        $this->movieRepository->add($movie, true);
        return $this->MapMovieToGetMovieDto($movie);
    }

    public function updateMovie(UpdateMovieDto $updateMovieDto): ?GetMovieDto
    {

        $movie = $this->movieRepository->findOneBy(["id"=>$updateMovieDto->getId(), "created_by"=>$this->getUserId()]);
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
        $movie = $this->movieRepository->findOneBy(["id"=>$id, "created_by"=>$this->getUserId()]);
        return $this->MapMovieToGetMovieDto($movie);
    }

    private function mapMovieToGetMovieDto($movie): GetMovieDto
    {
        return new GetMovieDto($movie->getId(), $movie->getName(), $movie->getCasts(), $movie->getReleaseDate()->format('d-m-Y'), $movie->getDirector(), $movie->getRatings());
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
        WHERE
        created_by = %userId
        ")
        ->setParameter("userId",$this->getUserId());
        return $query->getResult();
    }

    private function getUserId(): ?int
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if($user!= null){
            return $user->getId();
        }
        else{
            return null;
        }
    }
}