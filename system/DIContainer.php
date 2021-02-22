<?php

namespace system;
class DIContainer
{
    private static $instance;

    private function __construct()
    {}

    public static function getInstance(){
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $className
     * @return mixed
     */
    public function create($className)
    {

        try {
            $reflection = new \ReflectionClass($className);
            $dependencies = [];
            $singleton = !$reflection->isInstantiable();
            if ($singleton)
            {
                $method = $reflection->getMethod('getInstance');
            }
            else
            {
                $method = $reflection->getConstructor();
            }
            foreach ($method->getParameters() as $parameter)
            {
                $dependencies[] = $this->create($parameter->getClass()->name);
            }
            if ($singleton)
            {
                $instance = $className::getInstance(...$dependencies);
            }
            else
            {
                $instance = new $className(...$dependencies);
            }
            return $instance;
        } catch (\ReflectionException $e) {

        }
    }


}