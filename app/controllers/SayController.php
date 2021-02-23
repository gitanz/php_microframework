<?php


namespace app\controllers;


use app\requests\SayRequest;
use system\Request;
use system\Response;

class SayController extends BaseController
{
    public function __construct()
    {
    }

    public function hello(SayRequest $request, Response $response, $id)
    {
        $response->toJson($request->request->getInput()->data);
    }

}