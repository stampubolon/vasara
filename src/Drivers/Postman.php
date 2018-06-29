<?php

namespace DynEd\Vasara\Drivers;

use DynEd\Vasara\Exceptions\RouteNotExistException;

class Postman extends VasaraDriver
{
    /**
     * Create a new authentication exception.
     *
     * @param  string $message
     * @return void
     */
    public function __construct($decodedJson, $host = null)
    {
        // Use host from config file if not exist
        if ( ! $host) {
            $host = config('vasara.host');
        }

        // Define host
        $this->setHost($host);

        // Set info
        $this->setInfo($decodedJson->info->name, $decodedJson->info->description);

        // Set routes
        $this->setRoutes($decodedJson->item);
    }

    /**
     * Override function from VasaraDriver
     *
     * @param $name
     * @param $description
     */
    protected function setInfo($name, $description)
    {
        $info = new \stdClass();
        $info->name = $name;
        $info->description = $description;

        $this->info = $info;
    }

    /**
     * Override function from VasaraDriver
     *
     * @return mixed|null
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Override function from VasaraDriver
     *
     * @param $routes
     * @return mixed|void
     */
    protected function setRoutes($routes)
    {
        $this->extractRoutes($routes);
    }

    /**
     * Override function from VasaraDriver
     *
     * @return mixed|null
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Override function from VasaraDriver
     *
     * @param $host
     * @return mixed|void
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * Override function from VasaraDriver
     *
     * @return mixed|null
     */
    public function getHost()
    {
        return $this->host;
    }

    protected function extractRoutes($routes = null)
    {
        if ( ! $routes) {
            throw new RouteNotExistException();
        }

        // Loop through routes
        foreach ($routes as $key => $route) {
            if ($this->isFolder($route)) {
                $this->extractRoutes($route->item);
            } else {
                // Process an route here
                $_route = new \stdClass();
                $_route->name = $route->name;
                $_route->description = property_exists($route->request, 'description') ? $route->request->description : '';
                $_route->method = $route->request->method;
                $_route->header = $this->convertHeader($route->request->header);
                $_route->body = $this->convertBody($route->request->body);

                $_route->url = new \stdClass();
                $_route->url->host = $this->isValidUri(implode('/', $route->request->url->host)) ? implode('/', $route->request->url->host) : $this->host;
                $_route->url->path = implode('/', $route->request->url->path);
                $_route->url->full = $_route->url->host . '/' . $_route->url->path;

                $this->routes[] = $_route;
            }
        }
    }

    /**
     * Convert body params from json
     *
     * @param array $body
     * @return string
     */
    protected function convertBody($body = [])
    {
        return (optional($body)->{optional($body)->mode} ?
            (optional($body)->mode == 'raw' ?
                optional($body)->{optional($body)->mode} :
                $this->convertToJson(optional($body)->{optional($body)->mode})) :
            $this->convertToJson());
    }

    /**
     * Convert header params from json
     *
     * @param array $header
     * @return string
     */
    protected function convertHeader($header = [])
    {
        return (optional($header) ? $this->convertToJson($header) : $this->convertToJson());
    }

    /**
     * Convert inputted value to json
     *
     * @param $arrs
     * @return string
     */
    protected function convertToJson($arrs = [])
    {
        if ( ! is_array($arrs)) {
            return json_encode([]);
        }

        return json_encode($arrs);
    }

    /**
     * Check if processed route is collection of routes
     *
     * @param $route
     * @return bool
     */
    protected function isFolder($route)
    {
        return (bool) key_exists('item', $route);
    }
}