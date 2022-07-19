<?php
/**
 * Created by PhpStorm.
 * User: mijatra
 * Date: 1/15/2019
 * Time: 10:22 AM
 */

namespace App\Controller;


use App\Dto\User\PostUserDto;
use App\DTO\User\Request\PasswordResetDTO;
use App\Entity\User;
use App\GlobalSettings;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use App\DTO\User\Request\UserDTO;
use App\Utility\ActionType;
use App\DTO\User\Request\UserPasswordDTO;
use App\DTO\User\Request\UserEditDTO;
use App\DTO\User\Request\UserRegisterDTO;



class UserController  extends AbstractFOSRestController
{
    protected $service;
    private $tokenStorage;
    private $passwordEncoder;
    private $global;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    function __construct(UserService $service, TokenStorageInterface $token, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->service = $service;
        $this->tokenStorage = $token;
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @ParamConverter("postUserDto", converter="fos_rest.request_body")
     * @param PostUserDto $postUserDto
     * @return View
     */
    public function post(PostUserDto $postUserDto): View
    {
        if(!$postUserDto->isValid($this->validator)){
            throw new \InvalidArgumentException($postUserDto->getValidationErrors($this->validator));
        }

        $user = $this->service->addUser($postUserDto);

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_CREATED);
    }

}