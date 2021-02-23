<?php


namespace app\factories;


use app\factories\Factory;
use app\models\ClassModel;
use DateTime;

class ClassFactory extends Factory
{

    public static function make($input)
    {
        $class = new ClassModel();
        foreach($input as $key => $value){
            if(property_exists($class, $key)){
                $class->$key = $value;
            }
        }
        return $class;
    }

}