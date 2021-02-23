<?php


namespace app\controllers;


use app\repositories\ClassRepository;
use app\requests\ClassRequest;
use system\Response;

/*
 * TODO controller
 * */
class ClassController extends BaseController
{
    public ClassRepository $repository;

    public function __construct(ClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(ClassRequest $request, Response $response)
    {
        $status = $this->repository->createClasses($request->request->getInput()->data);
        $status_message = $status ? "Successfully created" : "Failed creating";
        $status_code = $status ? 201 : 422;
        return $response->toJson([
            "success" => $status,
            "message" => $status_message,
            "data" => $this->repository->getClasses()
        ], $status_code);
    }

}