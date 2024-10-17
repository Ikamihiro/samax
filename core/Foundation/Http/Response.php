<?php

namespace Core\Foundation\Http;

class Response
{
    /**
     * The content of the response.
     * 
     * @var string
     */
    protected string $content;

    /**
     * The headers of the response.
     * 
     * @var array
     */
    protected array $headers = [];

    /**
     * The status code of the response.
     * 
     * @var int
     */
    protected int $statusCode;

    public function __construct()
    {
        $this->statusCode = 200;
        $this->headers = [];
        $this->content = '';
    }

    /**
     * Set the status code of the response.
     * 
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Set the content of the response.
     * 
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set a header of the response.
     * 
     * @param string $header
     * @return $this
     */
    public function setHeader(string $header)
    {
        $this->headers = [$header];
        return $this;
    }

    /**
     * Get the headers of the response.
     * 
     * @return array
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * Get the status code of the response.
     * 
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get the content of the response.
     * 
     * @return string
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * Send the response.
     * 
     * @return void
     */
    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->content;

        return;
    }

    /**
     * Set the response as a redirect.
     * 
     * @param string $url
     * @return $this
     */
    public function redirect($url)
    {
        return $this->setHeader("Location: $url");
    }

    /**
     * Set the response as a JSON response.
     * 
     * @param array $data
     * @param int $statusCode
     * @return $this
     */
    public function json($data, $statusCode = 200)
    {
        $this->setStatusCode($statusCode);
        $this->setHeader('Content-Type: application/json');
        return $this->setContent(json_encode($data));
    }

    /**
     * Set the response as a No Content response with a 204 status code.
     * 
     * @param array $data
     * @return $this
     */
    public function noContent()
    {
        $this->setStatusCode(204);
        $this->setHeader('Content-Type: application/json');
        return $this->setContent('');
    }

    /**
     * Set the response as a Not Found response with a 404 status code.
     * 
     * @return $this
     */
    public function notFound()
    {
        $this->setStatusCode(404);
        return $this->setContent('Not found');
    }

    /**
     * Set the response as an Internal Server Error response with a 500 status code.
     * 
     * @return $this
     */
    public function internalServerError()
    {
        $this->setStatusCode(500);
        return $this->setContent('Internal server error');
    }
}