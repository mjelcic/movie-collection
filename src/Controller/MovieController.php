<?php

namespace App\Controller;

use App\Dto\ApiResponse\ApiResponse;
use App\Dto\Movie\PostMovieDto;
use App\Dto\Movie\UpdateMovieDto;
use App\Entity\Movie;
use App\Entity\User;
use App\Service\MovieService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class MovieController extends AbstractFOSRestController
{
    private MovieService $movieService;
    private ValidatorInterface $validator;


    public function __construct(MovieService $movieService, ValidatorInterface $validator)
    {
        $this->movieService = $movieService;
        $this->validator = $validator;
    }

    /**
     * @ParamConverter("postMovieDto", converter="fos_rest.request_body")
     * @param PostMovieDto $postMovieDto
     * @return View
     */
    public function post(PostMovieDto $postMovieDto) : View{
        $user =  $this->getUser();

        if(!$postMovieDto->isValid($this->validator)){
            throw new \InvalidArgumentException($postMovieDto->getValidationErrors($this->validator));
        }
        $movie = $this->movieService->addMovie($postMovieDto);
        return View::create($movie, Response::HTTP_CREATED);
    }

    /**
     * @ParamConverter("updateMovieDto", converter="fos_rest.request_body")
     * @param UpdateMovieDto $updateMovieDto
     * @return View
     */
    public function put(UpdateMovieDto $updateMovieDto) : View{
        if(!$updateMovieDto->isValid($this->validator)){
            throw new \InvalidArgumentException($updateMovieDto->getValidationErrors($this->validator));
        }
        $movie = $this->movieService->updateMovie($updateMovieDto);
        if($movie==null){
            return View::create($movie, Response::HTTP_NOT_FOUND);
        }
        return View::create($movie, Response::HTTP_CREATED);
    }

    public function getSingle($id): View
    {
        $dto = $this->movieService->getById($id);
        return View::create($dto, Response::HTTP_OK);
    }

    public function getAll(): View
    {
        $entities = $this->movieService->getAll();
        return View::create($entities, Response::HTTP_OK);
    }
}