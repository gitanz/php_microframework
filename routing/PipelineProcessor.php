<?php


namespace routing;


use system\Request;

interface PipelineProcessor
{
    public function process($route, Request $request);
}