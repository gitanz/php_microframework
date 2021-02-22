<?php


namespace controllers;


use system\Request;
use system\Response;

class SayController
{
    public function __construct(){}

    public function hello(Request $request, Response $response){

        return $response->toJson(['success'=> true, 'message' => 'hello'], 200);
    }

}