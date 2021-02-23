<?php

use system\RequestHandler;
use system\ResponseHandler;
include "./vendor/autoload.php";
include "./system/bootstrap.php";

$container = system\DIContainer::getInstance();

/** @var RequestHandler $requestHandler */
$requestHandler = $container->create(RequestHandler::class);
$response = $requestHandler->handle();

/* TODO event handling on responses */
/** @var ResponseHandler $responseHandler */
$responseHandler = $container->create(ResponseHandler::class);
$responseHandler->handle($response);