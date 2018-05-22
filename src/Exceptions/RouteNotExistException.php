<?php

namespace DynEd\Vasara\Exceptions;

use Exception;

class RouteNotExistException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param  string $message
     * @return void
     */
    public function __construct($message = 'There is no route to process.')
    {
        parent::__construct($message);
    }
}