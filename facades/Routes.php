<?php


namespace facades;


use system\DIContainer;

class Routes
{
    public static function __callStatic($method, $arguments){
        $container = DIContainer::getInstance();
        $router = $container->create(\routing\Router::class);
        $router->$method(...$arguments);
    }
}