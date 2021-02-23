<?php


namespace routing;


use system\Request;
use system\Validator;

abstract class FormRequest
{
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate()
    {
        $this->validator->validate($this->request->getInput()->data, $this->rules());
    }
}