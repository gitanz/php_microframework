<?php


namespace app\controllers;


use system\Request;
use system\Response;

class ErrorController
{
    public function __construct()
    {

    }

    public function notFound(Request  $request, Response $response)
    {
        $response->toJson(["success" => false, "message" => "Not found"], 404);
    }


}