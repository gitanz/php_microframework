<?php


namespace system;


class ResponseHandler
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function handle($response)
    {
        if(!$this->response->isHandled())
        {
            $headers = ["Content-Type" => "application/json"];
            if(isset($response['status_code']))
            {
                http_response_code($response['status_code']);
            }
            if(isset($response['body']))
            {
                echo json_encode($response['body']);
            }
            $this->handled = true;
        }
    }
}