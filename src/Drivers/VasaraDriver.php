<?php

namespace DynEd\Vasara\Drivers;

abstract class VasaraDriver
{
    /**
     * Defined info in all children class
     *
     * @var null
     */
    protected $info = null;

    /**
     * Defined routes in all children class
     *
     * @var null
     */
    protected $routes = null;

    /**
     * Define host to change host from downloaded API
     *
     * @var string
     */
    protected $host = '';

    /**
     * Set variable info using params
     *
     * @param $name
     * @param $description
     * @return mixed
     */
    abstract protected function setInfo($name, $description);

    /**
     * Retrieve info
     *
     * @return mixed
     */
    abstract protected function getInfo();

    /**
     * Convert routes and store in routes
     *
     * @param $routes
     * @return mixed
     */
    abstract protected function setRoutes($routes);

    /**
     * Retrieve routes
     *
     * @return mixed
     */
    abstract protected function getRoutes();

    /**
     * Convert host and store in host
     *
     * @param $host
     * @return mixed
     */
    abstract protected function setHost($host);

    /**
     * Retrieve host
     *
     * @return mixed
     */
    abstract protected function getHost();

    /**
     * Check if routes exist
     *
     * @return bool
     */
    public function routeExist()
    {
        return (bool) count($this->routes);
    }

    /**
     * Validating uri
     *
     * @param $uri
     * @return mixed
     */
    protected function isValidUri($uri)
    {
        return (bool) filter_var($uri, FILTER_VALIDATE_URL);
    }
}