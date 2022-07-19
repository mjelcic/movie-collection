<?php

namespace App\Tests\Service;

use App\Dto\Movie\PostMovieDto;
use App\Dto\Movie\UpdateMovieDto;
use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Service\MovieService;
use DateTime;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class MovieServiceTest extends TestCase
{
    /** @dataProvider newMovieEntity
     * @param Movie $movieEntity
     */
    public function testGetAll(Movie $movieEntity)
    {
        $movieEntities[] = $movieEntity;

        $abstractQueryMock = $this->createMock(AbstractQuery::class);
        $abstractQueryMock->method("getResult")
            ->willReturn($movieEntities);

        $queryMock = $this->createMock('\Doctrine\ORM\QueryBuilder');
        $queryMock->method("setParameter")
            ->willReturn($abstractQueryMock);

        $repoMock = $this->createMock(MovieRepository::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $securityMock = $this->createMock(Security::class);

        $entityManagerMock->method("createQuery")
            ->willReturn($queryMock);

        $service = new MovieService($repoMock, $entityManagerMock, $securityMock);
        $result = $service->getAll();

        $this->assertEquals($result[0]->getName(), $movieEntity->getName());
        $this->assertEquals($result[0]->getCasts(), $movieEntity->getCasts());
        $this->assertEquals($result[0]->getReleaseDate(), $movieEntity->getReleaseDate());
        $this->assertEquals($result[0]->getDirector(), $movieEntity->getDirector());
        $this->assertEquals($result[0]->getRatings(), $movieEntity->getRatings());
    }

    /** @dataProvider newMovieEntity
     * @param Movie $movieEntity
     */
    public function testGetById(Movie $movieEntity)
    {
        $user = new User();

        $repoMock = $this->createMock(MovieRepository::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $securityMock = $this->createMock(Security::class);

        $repoMock->method("findOneBy")
            ->willReturn($movieEntity);

        $securityMock->method("getUser")
            ->willReturn($user);


        $service = new MovieService($repoMock, $entityManagerMock, $securityMock);
        $result = $service->getById(1);

        $this->assertEquals($result->getName(), $movieEntity->getName());
        $this->assertEquals($result->getCasts(), $movieEntity->getCasts());
        $this->assertEquals($result->getReleaseDate(), $movieEntity->getReleaseDate()->format('d-m-Y'));
        $this->assertEquals($result->getDirector(), $movieEntity->getDirector());
        $this->assertEquals($result->getRatings(), $movieEntity->getRatings());
    }

    /** @dataProvider newUpdateMovieDto
     * @param UpdateMovieDto $dto
     */
    public function testUpdateMovie(UpdateMovieDto $dto)
    {
        $existingMovie = new Movie();
        $user = new User();

        $repoMock = $this->createMock(MovieRepository::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $securityMock = $this->createMock(Security::class);

        $repoMock->method("findOneBy")
            ->willReturn($existingMovie);

        $securityMock->method("getUser")
            ->willReturn($user);

        $service = new MovieService($repoMock, $entityManagerMock, $securityMock);
        $result = $service->updateMovie($dto);

        $this->assertEquals($result->getName(), $dto->getName());
        $this->assertEquals($result->getCasts(), $dto->getCasts());
        $this->assertEquals($result->getReleaseDate(), $dto->getReleaseDate());
        $this->assertEquals($result->getDirector(), $dto->getDirector());
        $this->assertEquals($result->getRatings(), $dto->getRatings());
    }

    /** @dataProvider newPostMovieDto
     * @param PostMovieDto $dto
     */
    public function testAddMovie(PostMovieDto $dto)
    {
        $user = new User();

        $repoMock = $this->createMock(MovieRepository::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $securityMock = $this->createMock(Security::class);

        $securityMock->method("getUser")
            ->willReturn($user);

        $service = new MovieService($repoMock, $entityManagerMock, $securityMock);

        $result = $service->addMovie($dto);

        $this->assertEquals($result->getName(), $dto->getName());
        $this->assertEquals($result->getCasts(), $dto->getCasts());
        $this->assertEquals($result->getReleaseDate(), $dto->getReleaseDate());
        $this->assertEquals($result->getDirector(), $dto->getDirector());
        $this->assertEquals($result->getRatings(), $dto->getRatings());
    }

    public function newMovieEntity(): array
    {
        $movie = new Movie();
        $movie->setName("The Titanic");
        $movie->setCasts([
            "DiCaprio",
            "Kate Winslet"
        ]);
        $movie->setReleaseDate(DateTime::createFromFormat('d-m-Y', "18-01-1998"));
        $movie->setDirector("James Cameron");
        $movie->setRatings([
            "imdb" => 7.8,
            "rotten_tomatto"=> 8.2
        ]);

        return [
            [$movie]
        ];
    }

    public function newUpdateMovieDto(): array
    {
        $dto = new UpdateMovieDto(
            1,
            "The Titanic",
            ["DiCaprio", "Kate Winslet"],
            "18-01-1998",
            "James Cameron",
            [ "imdb" => 7.8, "rotten_tomatto"=> 8.2]
        );

        return [
            [$dto]
        ];
    }

    public function newPostMovieDto(): array
    {
        $dto = new PostMovieDto(
            "The Titanic",
            ["DiCaprio", "Kate Winslet"],
            "18-01-1998",
            "James Cameron",
            [ "imdb" => 7.8, "rotten_tomatto"=> 8.2]
        );

        return [
            [$dto]
        ];
    }
}
