<?php


namespace routing;


use system\Request;

class UrlFilter implements PipelineProcessor
{

    public function process($routes, Request $request)
    {
        $requestUri = $request->getUri()->uri();

        $filtered_routes =  array_filter($routes,
            function ($route) use ($requestUri) {
                return preg_match("/^{$route->uri}$/", $requestUri, $matches);
            });

        $error = count($filtered_routes) ? null : 404;
        return [ $filtered_routes, $error, $output = null ];
    }

}