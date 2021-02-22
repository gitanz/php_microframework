<?php


namespace routing;


use InvalidArgumentException;
/*
 * TODO use factory pattern
 * create object for this class ApiRoute and WebRoute via factory
 * */
class ApiRoute
{
    public $method;
    public $uri;
    public $action;
    public $index;

    public static $verbs = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

    public function __construct(string $method, string $uri, string $action)
    {
        $this->method = $this->getMethod($method);
        $this->uri = $this->getUri($uri);
        $this->index = $this->getIndex();
        $this->action = $action;
    }

    public function getIndex()
    {
        $this->uriRegexer();
        return $this->uri;
    }

    public function uriRegexer()
    {
        $this->uri = str_replace('/', '\/', $this->uri);
        $matched = preg_match_all('/(\{\w+\})/', $this->uri, $matches);
        if($matched)
        {
            $this->uri =  str_replace($matches[1], '(\w+)', $this->uri);
        }
    }

    public function getUri($uri)
    {
        $uri = trim($uri);
        if(substr($uri, 0,5) != '/api/'){
            $uri = '/api' . $uri;
        }
        return $uri;
    }

    public function getMethod($method)
    {
        $method = strtoupper(trim($method));
        if( !in_array($method, self::$verbs))
        {
            throw new InvalidArgumentException("$method is not valid HTTP verb.", 0);
        }
        return $method;
    }
}