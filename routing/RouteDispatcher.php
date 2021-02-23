<?php


namespace routing;


use system\DIContainer;
use system\Response;
use system\Validator;

class RouteDispatcher
{
    public $container;

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    public function process($route, $arguments)
    {
        /*
         * TODO refactor
         * */
        list($controller, $action) = explode('@', $route->action);
        $controller = $this->container->create('app\controllers\\' . $controller);
        $reflection = new \ReflectionClass(get_class($controller));
        $method = $reflection->getMethod($action);

        $dependencies = $this->getDependencies($method->getParameters());
        $dependencies = [...$dependencies, ...$arguments];
        return $controller->$action(...$dependencies);
    }


    private function getDependencies($parameters)
    {
        $dependencies = [];
        $validRequest = true;
        foreach ($parameters as $parameter) {

            $dependentClass = $parameter->getClass();

            if (!is_null($dependentClass)) {
                $dependencies[] = $this->container->create($dependentClass->name);
            }

            /* execute request validation injection */
            /* TODO implement pipeline for Authorization/Validation dependencies */
            /**/
            if (!is_null($dependentClass) &&
                $dependentClass->getParentClass() &&
                $dependentClass->getParentClass()->getName() == 'routing\\FormRequest') {
                $formRequest = end($dependencies);
                $this->validateHook($formRequest);
            }
        }

        return $dependencies;
    }

    private function validateHook($formRequest)
    {

        $formRequest->setValidator(new Validator());
        $formRequest->validate();
        $valid = $formRequest->validator->isValid();
        if (!$valid) {
            $response = $this->container->create(Response::class);
            $response->send400($formRequest->validator->getErrors());
        }
    }

}