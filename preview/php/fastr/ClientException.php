<?php

/**
 * Class ClientException
 * @author  Hidde Beydals <hidde@getfastr.co>
 */
final class ClientException extends Exception
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * Return the errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the errors.
     *
     * @param array $errors
     */
    public function setErrors(array $errors = [ ])
    {
        $this->errors = $errors;
    }
}