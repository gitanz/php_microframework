<?php

namespace system;

class Uri
{
    private $scheme;
    private $hostname;
    private $port;
    private $base_url;
    private $uri;

    private static $instance;

    private function __construct()
    {
        $this->scheme = isset($_SERVER['https'])? 'https': 'http';
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->port = $_SERVER['SERVER_PORT'];
        $this->base_url = "{$this->scheme}://{$this->hostname}" . ($this->port != 80 ? ": {$this->port}" : '');
        $this->uri = $requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function scheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function hostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function port(): string
    {
        return $this->port;
    }


    /**
     * @return string
     */
    public function baseUrl(): string
    {
        return $this->base_url;
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }


}