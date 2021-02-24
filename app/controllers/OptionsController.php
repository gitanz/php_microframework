<?php


namespace app\controllers;


use system\Request;
use system\Response;

class OptionsController
{
    public function __construct()
    {

    }

    /*
     * Preflight
     * */
    public function handleCors(Request  $request, Response $response)
    {
        $response->sendCors();
    }


}