<?php


namespace routing;


use system\DIContainer;

class RouteDispatcher
{
    public $container;

    public function __construct(DIContainer $container){
        $this->container = $container;
    }

    public function process($route, $arguments)
    {
        /*
         * TODO refactor
         * */
        list($controller, $action) =  explode('@', $route->action);
        $controller = $this->container->create('app\controllers\\'.$controller);
        $reflection = new \ReflectionClass(get_class($controller));
        $method = $reflection->getMethod($action);
        $parameters = $method->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter)
        {
            if(!is_null($parameter->getClass()))
            {
                $dependencies[] = $this->container->create($parameter->getClass()->name);
            }
        }
        $dependencies = [...$dependencies, ...$arguments];
        return $controller->$action(...$dependencies);
    }
}