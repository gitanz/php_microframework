<?php


namespace system;


class Response
{
    private $handled;
    private static $instance;

    private function __construct()
    {}

    public static function getInstance()
    {
        if( is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function toJson($data, $response_code=200, array $headers = [])
    {
        $headers += ["Content-Type" => "application/json"];
        http_response_code($response_code);
        foreach($headers as $name => $text)
        {
            header("$name: $text");
        }

        echo json_encode($data);
        $this->handled = true;
        return $data;
    }

    public function send400($errors)
    {
        $headers = ["Content-Type" => "application/json"];
        http_response_code(400);
        foreach($headers as $name => $text)
        {
            header("$name: $text");
        }
        $data = ["success"=>false, "message"=>"Invalid request", "data" => $errors];
        echo json_encode($data);
        exit;

    }

    public function send404()
    {
        $headers = ["Content-Type" => "application/json"];
        http_response_code(404);
        foreach($headers as $name => $text)
        {
            header("$name: $text");
        }
        $data = ["success"=>false, "message"=>"Not found"];
        echo json_encode($data);
        exit;
    }

    public function send405()
    {
        $headers = ["Content-Type" => "application/json"];
        http_response_code(405);
        foreach($headers as $name => $text)
        {
            header("$name: $text");
        }
        $data = ["success"=>false, "message"=>"Method not allowed"];
        echo json_encode($data);
        $this->handled = true;
    }

    public function isHandled()
    {
        return (bool)$this->handled;
    }
}