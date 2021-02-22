<?php


namespace controllers;


use requests\SayRequest;
use system\Request;
use system\Response;

class SayController
{
    public function __construct(){}

    public function hello(SayRequest $request, Response $response){
        if(!$request->authorized)
        {
            return [
                'body' => ['success'=> true, 'message' => 'Unauthorized'],
                'status_code' => 401
            ];
        }
        if(!$request->valid)
        {
            return [
                'body' => ['success'=> true, 'message' => 'Invalid request'],
                'status_code' => 400
            ];
        }
        return [
            'body' => ['success'=> true, 'message' => 'hello'],
            'status_code' => 200
        ];



    }

}