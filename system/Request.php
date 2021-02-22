<?php

namespace system;
class Request
{
    private $uri;
    private $input;
    private $parameters;
    private $http_headers;
    private $http_method;

    private static $instance;

    private function __construct(
        Uri $uri,
        Input $input,
        QueryParameters $queryParameters,
        HttpRequestHeaders $headers,
        HttpMethod $method
    )
    {
        $this->uri = $uri;
        $this->input = $input;
        $this->parameters = $queryParameters;
        $this->http_headers = $headers;
        $this->http_method = $method;
    }

    /**
     * @param Uri $uri
     * @param Input $input
     * @param QueryParameters $queryParameters
     * @param HttpRequestHeaders $headers
     * @param HttpMethod $method
     * @return Request
     */
    public static function getInstance(
        Uri $uri,
        Input $input,
        QueryParameters $queryParameters,
        HttpRequestHeaders $headers,
        HttpMethod $method
    )
    {
        if(is_null(self::$instance)){
            self::$instance = new self($uri, $input, $queryParameters, $headers, $method);
        }
        return self::$instance;
    }

    /**
     * @return Uri
     */
    public function getUri(): Uri
    {
        return $this->uri;
    }

    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

    /**
     * @return QueryParameters
     */
    public function getParameters(): QueryParameters
    {
        return $this->parameters;
    }

    /**
     * @return HttpRequestHeaders
     */
    public function getHttpHeaders(): HttpRequestHeaders
    {
        return $this->http_headers;
    }

    /**
     * @return HttpMethod
     */
    public function getHttpMethod(): HttpMethod
    {
        return $this->http_method;
    }

}