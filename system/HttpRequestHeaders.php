<?php

namespace system;

class HttpRequestHeaders
{
    private $headers;
    private static $instance;

    /**
     * HttpRequestHeaders constructor.
     */
    private function __construct(){

        $this->headers = array_filter($_SERVER, function($key)
        {
            $prefix = substr($key, 0, 5);
            return strtolower($prefix) == 'http_';
        }, ARRAY_FILTER_USE_KEY);

    }

    /**
     * @return HttpRequestHeaders
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
     * @return array
     */
    public function all(): array
    {
        return $this->headers;
    }

    /**
     * @param string $header
     * @return string
     */
    public function get(string $header): string
    {
        return $this->headers[$header];
    }

}