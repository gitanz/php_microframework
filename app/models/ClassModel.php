<?php


namespace app\models;

use DateTime;

class ClassModel extends Model
{
    public int $id;
    public string $class_name;
    public string $date;
    public int $capacity;
    public bool $lock = false;
}