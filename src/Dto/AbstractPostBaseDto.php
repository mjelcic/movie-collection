<?php

namespace App\Dto;

use App\Utility\MError;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractPostBaseDto
{
    private $validationErrors = null;

    public function isValid(ValidatorInterface $validator)
    {
        $this->validate($validator);

        return count($this->validationErrors) > 0 ? false : true;
    }

    /**
     * @param string $format
     * @return null|string|\Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function getValidationErrors(ValidatorInterface $validator)
    {
        if(null === $this->validationErrors){
            $this->validate($validator);
        }

        $errors = array();
        if (count($this->validationErrors) > 0) {
            foreach ($this->validationErrors as $error) {
               // $errors[] = new MError($error->getPropertyPath(), $error->getMessage());
                $errors[] = $error->getPropertyPath() . ": " . $error->getMessage();
            }
        }

        return $errors[0];
    }

    private function validate(ValidatorInterface $validator)
    {
        $this->validationErrors = $validator->validate($this);
    }
}