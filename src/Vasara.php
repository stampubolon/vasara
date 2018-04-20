<?php

namespace DynEd\Vasara;

// use DynEd\Beacon\Handler\BaseHandler;
// use Exception;

class Vasara {

    /**
     * Handler
     *
     * @var BaseHandler|null
     */
    private $handler = null;

    /**
     * Beacon constructor
     *
     * @param BaseHandler $handler
     */
    public function __construct(BaseHandler $handler = null)
    {
        $this->handler = $handler;
    }

    /**
     * Report the error to handler
     *
     * @param Exception $e
     */
    // public function report(Exception $e)
    // {
    //     if( ! $this->handler) {
    //         return;
    //     }

    //     $this->handler->sendReport($e);
    // }
}