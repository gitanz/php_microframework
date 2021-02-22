<?php


namespace system;


class Response
{
    public function __construct()
    {}

    public function toJson(array $data, $response_code=200, array $headers = [])
    {
        $headers += ["Content-Type" => "application/json"];
        http_response_code($response_code);
        foreach($headers as $name => $text)
        {
            header("$name: $text");
        }
        echo json_encode($data);
        return $data;
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
        return $data;
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
        return $data;
    }
}