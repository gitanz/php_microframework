<?php


namespace app\repositories;


use app\factories\ClassFactory;
use app\models\ClassModel;
use PHPUnit\Util\Exception;

class ClassRepository
{
    private array $classes;

    private ClassFactory $classFactory;

    public function __construct()
    {
        $this->classes = [];
    }

    public function seedClasses()
    {
        $this->createClasses([
          "class_name"=> "mock",
          "start_date"=> "2021-04-01",
          "end_date"=> "2021-04-10",
          "capacity"=> "20"
        ]);
    }

    public function createClasses($input)
    {
        $date = date_create($input['start_date']);
        $endDate = date_create($input['end_date']);

        while($date <= $endDate){
            $input['date'] = date_format($date, 'Y-m-d');
            $model = ClassFactory::make($input);
            date_add($date, date_interval_create_from_date_string("1 day"));
            $this->addClass($model);
        }

        return true;
    }

    public function getClasses()
    {
        return $this->classes;
    }


    public function addClass(ClassModel $classModel)
    {
        try{
            $classModel->id = count($this->classes)+1;
            $this->classes[] = $classModel;
            return true;
        }catch(\Exception $e){
            return false;
        }

    }

    public function acquireLock($class)
    {
        try{
            if($class->lock == false){
                $class->lock = true;
                $this->updateClass($class);
                return true;
            }
            throw new Exception("class locked");
        }catch (\Exception $e)
        {
            return false;
        }
    }

    public function releaseLock($class)
    {
        try{
            $class->lock = false;
            $this->updateClass($class);
            return true;
        }catch (\Exception $e)
        {
            return false;
        }
    }

    public function updateClass($class)
    {
        try{
            $this->classes[$class->id - 1] = $class;
            return true;
        }catch(\Exception $e){
            return false;
        }

    }

    public function bookClass(&$class)
    {
        $class->capacity = $class->capacity - 1;
    }

}