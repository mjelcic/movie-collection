<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/16/2019
 * Time: 2:51 PM
 */

namespace App\Service;

use App\Dto\User\GetUserDto;
use App\Dto\User\PostUserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService
{

    protected $passwordEncoder;
    private $entityManager;
    private $userRepository;

    function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, UserRepository  $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;

    }

    public function addUser(PostUserDto $postUserDto): GetUserDto
    {
        $user = new User();
        $user->setUsername($postUserDto->getUsername());
        $user->setEmail($postUserDto->getEmail());
        $user->setRoles(["ROLE_USER"]);
        $user->setCreatedBy(1);
        $user->setPassword($postUserDto->getPassword());
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $this->userRepository->add($user, true);
        return $this->mapUserToGetUserDto($user);
    }

    public function getUserById($id)
    {
        $query = $this->entityManager->createQuery('
        SELECT NEW App\DTO\User\Response\UserDTO(
        u.id,
        u.email,
        u.roles,
        u.first_name,
        u.last_name
        )
        FROM App\Entity\User u
        WHERE u.id = :id
        ')->setParameter("id", $id);
        $results = $query->execute();
        return $results[0];
    }

    protected function beforeEntitySave($entity, $userId)
    {
        if (!$entity->getId()) {
            $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPassword()));
            $double = $this->entityManager->getRepository(User::class)->findOneBy(array("email" => $entity->getEmail()));
            $entity->setRoles(array("ROLE_USER"));
            if ($double) {
                throw new \InvalidArgumentException("Ovaj email se već koristi!" . $entity->getId());
            }
        }

    }

    private function mapUserToGetUserDto($user): GetUserDto
    {
        return new GetUserDto($user->getId(), $user->getUsername(),$user->getEmail());
    }


}