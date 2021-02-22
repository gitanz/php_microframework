<?php

namespace system;

class QueryParameters
{

    private $queries;

    private static $instance;

    /**
     * QueryParameters constructor.
     */
    private function __construct()
    {
        $this->queries = $_GET;
    }

    /**
     * @return QueryParameters
     */
    public static function getInstance()
    {
        if( is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->queries;
    }

    /**
     * @param string $query
     * @return string
     */
    public function get(string $query)
    {
        return $this->queries[$query];
    }

}