<?php


namespace system;


use routing\Router;

class RequestHandler
{
    private $request;
    private $container;
    private $router;

    /*
     * TODO
     * currently only for api routes
     * implement polymorphism for router and create service provider for different morphs
     * */
    public function __construct(DIContainer $container, Request $request, Router $router)
    {
        $this->container = $container;
        $this->request = $request;
        $this->router = $router;
    }

    public function handle()
    {
        $this->bootstrap();
        return $this->dispatcher();
    }

    public function bootstrap()
    {
        require_once "routing/routes.php";
    }

    public function dispatcher()
    {
        return $this->router->dispatch($this->request);
    }

}