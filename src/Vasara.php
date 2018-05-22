<?php

namespace DynEd\Vasara;

use DynEd\Vasara\Exceptions\DriverOutOfBoundException;

class Vasara
{
    /**
     * Info of postman
     *
     * @var null
     */
    private $postmanInfo = null;

    /**
     * Item of postman
     *
     * @var \Illuminate\Support\Collection|null
     */
    private $postmanItem = null;

    /**
     * Event of postman
     *
     * @var \Illuminate\Support\Collection|null
     */
    private $postmanEvent = null;

    /**
     * Collection of all items
     *
     * @var \Illuminate\Support\Collection|null
     */
    private $items = null;

    /**
     * Default host for routes
     *
     * @var string
     */
    private $host = 'http://localhost';

    /**
     * All available drivers
     *
     * @var array
     */
    private $availableDriver = ['postman'];

    var     $vasaraJson      = null;

    var     $vasaraObject    = null;

    var     $driver          = '';

    /**
     * Vasara constructor.
     *
     * @param $json
     * @param null $driver
     * @throws DriverOutOfBoundException|mixed
     */
    public function __construct($json, $driver = null)
    {
        // Use driver from config if not setup
        if ( ! $driver) {
            $driver = config('vasara.driver');
        }

        // Throw exception if driver not available
        if ( ! in_array($driver, $this->availableDriver)) {
            throw new DriverOutOfBoundException();
        }

        $this->driver = $driver;

        $this->vasaraJson = $json;
    }

    /**
     * Instantiate driver and process file immidiately
     */
    public function run()
    {
        // Change first character to uppercase
        $class = 'DynEd\\Vasara\\Drivers\\' . ucfirst($this->driver);

        $this->vasaraObject = new $class(json_decode($this->vasaraJson), $this->host);
    }

    /**
     * Return vasara info
     *
     * @return mixed
     */
    public function getInfo()
    {
        return $this->vasaraObject->getInfo();
    }

    /**
     * Return all in proper format routes
     *
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->vasaraObject->getRoutes();
    }

    /**
     * Change host of url
     *
     * @param $host
     */
    public function changeHost($host)
    {
        $this->host = $host;
    }

    /**
     * Check if route exist
     *
     * @return bool
     */
    public function routeExist()
    {
        return $this->vasaraObject->routeExist();
    }
}