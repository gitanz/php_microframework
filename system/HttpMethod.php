<?php

namespace system;

class HttpMethod
{
    private $method;
    private static $instance;

    /**
     * HttpMethod constructor.
     */
    private function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return HttpMethod
     */
    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->method;
    }

}