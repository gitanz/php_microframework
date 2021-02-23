<?php


namespace app\requests;


use system\Request;
use app\validators\Validator;

class SayRequest
{
    public Request $request;
    public Validator $validator;

    public function __construct(Request $request, Validator $validator)
    {

        $this->validator = $validator;
        $this->request = $request;
        $this->validator->validate($request->getInput()->data, $this->rules());
    }

    private function rules()
    {
        return [
            'name' => ['required', 'min:4' ,'max:255'],
            'start_date' => ['date', 'relation:end_date:date:lt'],
            'end_date' => ['date', 'relation:start_date:date:gt'],
            'capacity' => ['numeric', 'min:10', 'max:30']
        ];
    }


}