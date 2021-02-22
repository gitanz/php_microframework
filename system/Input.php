<?php

namespace system;

class Input
{

    public $data;

    private static $instance;

    private function __construct()
    {
        $this->data = $_POST;
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