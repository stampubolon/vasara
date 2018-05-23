<?php

namespace DynEd\Vasara;

use DynEd\Vasara\Exceptions\DriverOutOfBoundException;

class Vasara
{
    /**
     * Default host for routes
     *
     * @var string
     */
    private $host = '';

    /**
     * All available drivers
     *
     * @var array
     */
    private $availableDriver = ['postman'];

    /**
     * Store json here
     *
     * @var null
     */
    var $vasaraJson = null;

    /**
     * Store object from driver here
     *
     * @var null
     */
    var $vasaraObject = null;

    /**
     * Choosen driver here
     *
     * @var \Illuminate\Config\Repository|mixed|null|string
     */
    var $driver = '';

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
        $driver = 'DynEd\\Vasara\\Drivers\\' . ucfirst($this->driver);

        $this->vasaraObject = new $driver(json_decode($this->vasaraJson), $this->host);
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