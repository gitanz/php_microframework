<?php


namespace routing;


use system\Request;

class MethodFilter implements PipelineProcessor
{

    public function process($routes, Request $request)
    {
        $requestMethod = $request->getHttpMethod()->get();

        $filtered_routes =  array_filter($routes,
                function ($route) use ($requestMethod) {
                    return $route->method == $requestMethod;
                }
            );

        $error = count($filtered_routes) ? null : 405;
        return [$filtered_routes, $error, $output = null];

    }
}