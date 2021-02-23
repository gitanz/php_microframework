<?php


namespace app\requests;


use routing\FormRequest;
use system\Request;
use system\Validator;

class BookingRequest extends FormRequest
{
    public Request $request;
    public Validator $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function rules()
    {
        return [
            'username' => ['required', 'min:4' ,'max:255'],
            'date' => ['date']
        ];
    }
}