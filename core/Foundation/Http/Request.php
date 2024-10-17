<?php

namespace Core\Foundation\Http;

class Request
{
    /**
     * The server data from $_SERVER.
     * 
     * @var array
     */
    protected array $serverData = [];

    /**
     * The get data from $_GET.
     * 
     * @var array
     */
    protected array $getData = [];

    /**
     * The post data from $_POST.
     * 
     * @var array
     */
    protected array $postData = [];

    public function __construct()
    {
        $this->serverData = $_SERVER;
        $this->getData = $_GET;
        $this->postData = $_POST;
    }

    /**
     * Capture the incoming request
     * 
     * @return static
     */
    public static function capture()
    {
        return new static;
    }

    /**
     * Get the request method.
     * 
     * @return string
     */
    public function method()
    {
        return strtolower($this->serverData['REQUEST_METHOD']);
    }

    /**
     * Check if the request is a JSON request
     * 
     * @param string $method
     * @return bool
     */
    public function isJson()
    {
        $contentType = $this->serverData['CONTENT_TYPE'] ?? '';

        if (empty($contentType)) {
            return false;
        }

        return strpos($this->serverData['CONTENT_TYPE'], 'application/json') !== false;
    }

    /**
     * Get the request URL.
     * 
     * @return string
     */
    public function url()
    {
        $path = $this->serverData['REQUEST_URI'];
        $position = strpos($path, '?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    /**
     * Get the request URI.
     * 
     * @return string
     */
    public function query()
    {
        $data = [];

        foreach ($this->getData as $key => $value) {
            $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $data;
    }

    /**
     * Get the request body.
     * 
     * @return array
     */
    private function getBodyAsArray()
    {
        $data = [];

        foreach ($this->postData as $key => $value) {
            $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $data;
    }

    /**
     * Get the request body from JSON.
     * 
     * @return array
     */
    private function getBodyFromJson()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        return $data;
    }

    /**
     * Get the request body.
     * 
     * @return array
     */
    public function body()
    {
        if ($this->isJson()) {
            return $this->getBodyFromJson();
        }

        return $this->getBodyAsArray();
    }

    /**
     * Get all the request data.
     * 
     * @return array
     */
    public function all()
    {
        return array_merge(
            ['body' => $this->body() ?? []],
            ['query' => $this->query() ?? []]
        );
    }
}
