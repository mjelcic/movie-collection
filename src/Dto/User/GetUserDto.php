<?php


namespace App\Dto\User;


use App\Dto\AbstractPostBaseDto;

class GetUserDto extends AbstractPostBaseDto
{
    private $id;
    private $email;
    private $username;
    private $password;

    /**
     * PostUserDto constructor.
     * @param $id
     * @param $email
     * @param $username
     */
    public function __construct($id, $email, $username)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

}