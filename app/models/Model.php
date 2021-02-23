<?php


namespace app\models;


class Model
{
    public function mapParameters(array $input)
    {
        foreach($input as $key => $value)
        {
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }
}