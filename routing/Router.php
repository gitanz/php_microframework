<?php


namespace routing;


use system\DIContainer;
use system\Request;

/*
 * TODO This class Router is currently concrete for API routing only
 * */

class Router
{
    private $routes = [];
    private $dispatch_to;
    private $container;

    private static $instance;

    private function __construct(DIContainer $container){
        $this->container = $container;
    }

    /**
     * @param DIContainer $container
     * @return Router
     */
    public static function getInstance(DIContainer $container)
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self($container);
        }
        return self::$instance;
    }

    /**
     * @param $uri
     * @param $action
     */
    public function get($uri, $action)
    {
        $apiRoute = new ApiRoute('GET', $uri, $action);
        $this->routes['api'][$apiRoute->index] = $apiRoute;
    }

    /**
     * @param $uri
     * @param $action
     */
    public function post($uri, $action)
    {
        $apiRoute = new ApiRoute('POST', $uri, $action);
        $this->routes['api'][$apiRoute->index] = $apiRoute;
    }

    /**
     * @param $uri
     * @param $action
     */
    public function put($uri, $action)
    {
        $apiRoute = new ApiRoute('PUT', $uri, $action);
        $this->routes['api'][$apiRoute->index] = $apiRoute;
    }

    /**
     * @param $uri
     * @param $action
     */
    public function delete($uri, $action)
    {
        $apiRoute = new ApiRoute('DELETE', $uri, $action);
        $this->routes['api'][$apiRoute->index] = $apiRoute;
    }

    public function apiRoutes()
    {
        return $this->routes['api']?? null;
    }

    public function dispatch(Request $request)
    {
        try
        {

            return (new Pipeline($this->apiRoutes(), $request))
                ->through(
                [
                    new UrlFilter(),
                    new MethodFilter(),
                    new ArgumentsFilter()
                ]
            )->finally( new RouteDispatcher($this->container) );
        }
        catch (\Exception $e){
            throw $e;
        }

    }

}