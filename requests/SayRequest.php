<?php


namespace requests;


use system\Request;

class SayRequest
{
    public $valid;
    public $authorized;

    public function __construct(Request $request)
    {
        $this->authorize();
        $this->validate();
    }

    public function validate()
    {
        $this->valid = true;
    }

    public function authorize()
    {
        $this->authorized = true;
    }
}