<?php


namespace routing;


use app\validators\Validator;
use system\Request;

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