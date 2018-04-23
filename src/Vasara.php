<?php

namespace DynEd\Vasara;

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
     * Beacon constructor
     *
     * @param BaseHandler $handler
     */
    public function __construct($postmanJson)
    {
        // Extract input value
        $postman = json_decode($postmanJson);

        // Separate all element to each variable
        $this->postmanInfo = $postman->info;
        $this->postmanItem = $postman->item;
        $this->postmanEvent = $postman->event;

        // Define items as collection
        $this->items = collect([]);
    }

    /**
     * Return postman info
     *
     * @return null
     */
    public function getPostmanInfo()
    {
        return $this->postmanInfo;
    }

    /**
     * Return postman item
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getPostmanItem()
    {
        return $this->postmanItem;
    }

    /**
     * Return postman event
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getPostmanEvent()
    {
        return $this->postmanEvent;
    }

    /**
     * Return all items of postman
     * Extract item before return it
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getRoutes()
    {
        $this->extractItemRoutes();

        return $this->items;
    }

    /**
     * Change host of postman url
     *
     * @param $host
     */
    public function changeHost($host)
    {
        $this->host = $host;
    }

    /**
     * Extract each items of postman
     *
     * @param $items
     */
    public function extractItemRoutes($items = null)
    {
        // Use postman item if items param not defined
        $items = $items ?: $this->postmanItem;

        foreach ($items as $key => $item) {
            if (key_exists('item', $item)) {
                // Item element mean this is a folder
                $this->extractItemRoutes($item->item);
            } else {
                // This is item from a folder or postman
                $_item = new \stdClass();
                $_item->name = $item->name;
                $_item->description = property_exists($item->request, 'description') ? $item->request->description : '';
                $_item->method = $item->request->method;
                $_item->header = $this->convertPostmanBody($item->request->header);
                $_item->body = $this->convertPostmanBody($item->request->body);

                $_item->url = new \stdClass();
                $_item->url->host = $this->isValidUri(implode('/', $item->request->url->host)) ? implode('/', $item->request->url->host) : $this->host;
                $_item->url->path = implode('/', $item->request->url->path);
                $_item->url->full = $_item->url->host . '/' . $_item->url->path;

                $this->items->push($_item);
            }
        }
    }

    /**
     * Convert body params from postman json
     *
     * @param array $postmanBody
     * @return string
     */
    protected function convertPostmanBody($postmanBody = [])
    {
        return (optional($postmanBody)->{optional($postmanBody)->mode} ?
            $this->concatPostmanArray(optional($postmanBody)->{optional($postmanBody)->mode}) :
            json_encode([]));
    }

    /**
     * Convert header params from postman json
     *
     * @param array $postmanHeader
     * @return string
     */
    protected function convertPostmanHeader($postmanHeader = [])
    {
        return (optional($postmanHeader) ? $this->concatPostmanArray($postmanHeader) : json_encode([]));
    }

    /**
     * Convert inputted value to postman json
     *
     * @param $postmanArray
     * @return string
     */
    protected function concatPostmanArray($postmanArray = [])
    {
        $return = [];

        foreach ($postmanArray as $postmanElement) {
            // Authorization defined in project headers
            if ($postmanElement->key != 'Authorization') {
                $return[$postmanElement->key] = $postmanElement->value;
            }
        }

        return json_encode($return);
    }

    /**
     * Validating uri
     *
     * @param $uri
     * @return mixed
     */
    private function isValidUri($uri)
    {
        return filter_var($uri, FILTER_VALIDATE_URL);
    }
}