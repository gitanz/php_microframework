<?php


namespace routing;


use system\Request;

class ArgumentsFilter implements PipelineProcessor
{

    public function process($routes, Request $request)
    {
        /* use the first route among the filtered */
        $selected_route = array_shift($routes);
        $requestUri = $request->getUri()->uri();
        $matched = preg_match("/^{$selected_route->uri}$/", $requestUri, $matches);
        if($matched){
            array_shift($matches);
        }
        return [$selected_route, $error=null, $arguments = $matches];
    }

}