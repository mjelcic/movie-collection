<?php


namespace App\Dto\User;


use App\Dto\AbstractPostBaseDto;
use Symfony\Component\Validator\Constraints as Assert;

class PostUserDto extends AbstractPostBaseDto
{

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @Assert\Type(type="string", message="Value {{ value }} must be string!")
     * @Assert\NotBlank(message="Value cannot be empty!")
     * @Assert\Length(min="1", max="100", minMessage="Value must be between 1 and 100 characters long!")
     */
    private $username;

    /**
     * @Assert\Type(type="string", message="Value: {{ value }} is not valid!")
     * @Assert\NotBlank(message="Field cannot be empty!")
     * @Assert\Length(min="6", minMessage="Password must be at least {{ limit }} characters long!")
     */
    private $password;

    /**
     * PostUserDto constructor.
     * @param $email
     * @param $username
     * @param $password
     */
    public function __construct($email, $username, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
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

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}