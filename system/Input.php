<?php

namespace system;

class Input
{

    public $data;

    private static $instance;

    private function __construct()
    {
        $this->data = (array)json_decode(file_get_contents("php://input"), true);
    }

    public static function getInstance()
    {
        if( is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }


}