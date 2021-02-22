<?php


namespace routing;


use system\Request;
use system\Response;

class Pipeline
{

    public $mixed;
    public $error;
    public $using;
    public $output;

    public function __construct(array $mixed, $using)
    {
        $this->mixed = $mixed;
        $this->using = $using;
    }

    public function through(array $pipes)
    {
        foreach($pipes as $pipe)
        {
            list($this->mixed, $this->error, $this->output) = $pipe->process($this->mixed, $this->using);
            if($this->error)
            {
                $this->errorOutlet();
                break;
            }
        }
        return $this;
    }

    public function finally($dispenser)
    {
        if(!$this->error)
            return $dispenser->process($filtered = $this->mixed, $this->output);
    }

    public function errorOutlet()
    {
        $response = Response::getInstance();
        switch ($this->error):
            case 404:
                $response->send404();
                break;
            case 405:
                $response->send405();
                break;
            default:
                break;
        endswitch;
    }

}