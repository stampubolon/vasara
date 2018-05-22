<?php

namespace DynEd\Vasara\Exceptions;

use Exception;

class DriverOutOfBoundException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param  string $message
     * @return void
     */
    public function __construct($message = 'Driver out of bound (driver not available).')
    {
        parent::__construct($message);
    }
}