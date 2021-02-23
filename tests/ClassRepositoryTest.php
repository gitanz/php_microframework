<?php
declare(strict_types=1);


namespace tests;


use app\models\ClassModel;
use app\repositories\ClassRepository;
use PHPUnit\Framework\TestCase;
use system\DIContainer;

class ClassRepositoryTest extends TestCase
{
    public function testCreateClasses()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $input = [
            "class_name"=> "mock",
            "start_date"=> "2021-04-01",
            "end_date"=> "2021-04-10",
            "capacity"=> "20"
        ];
        $respository->createClasses($input);
        $classes = $respository->getClasses();
        $this->assertEquals(10, count($classes),"created 10 classes");
    }

    public function testCreateClassesConsecutive()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $input = [
            "class_name"=> "mock",
            "start_date"=> "2021-04-01",
            "end_date"=> "2021-04-10",
            "capacity"=> "20"
        ];
        $respository->createClasses($input);
        $classes = $respository->getClasses();

        $this->assertEquals("2021-04-02", $classes[1]->date,"created 10 classes");
    }

    public function testLockAcquisition()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $class = new ClassModel();

        $class->class_name = "mock";
        $class->date = "2020-03-01";
        $class->capacity = 20;
        $class->lock = true;
        $class->id = 1;

        $this->assertFalse($respository->acquireLock($class));
    }

    public function testLockRelease()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $class = new ClassModel();
        $class->class_name = "mock";
        $class->date = "2020-03-01";
        $class->capacity = 20;
        $class->lock = true;
        $class->id = 1;

        $this->assertTrue($respository->releaseLock($class));
    }

    public function testUpdateClass()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $input = [
            "class_name"=> "mock",
            "start_date"=> "2021-04-01",
            "end_date"=> "2021-04-10",
            "capacity"=> "20"
        ];
        $respository->createClasses($input);
        $classes = $respository->getClasses();
        $class = $classes[0];
        $class->class_name = "mockedYay";
        $respository->updateClass($class);
        $updatedClass = $classes[$class->id - 1];
        $this->assertEquals($updatedClass->class_name, "mockedYay");
    }

    public function testBookClass()
    {
        $diContainer = DIContainer::getInstance();
        $respository = $diContainer->create(ClassRepository::class);
        $input = [
            "class_name"=> "mock",
            "start_date"=> "2021-04-01",
            "end_date"=> "2021-04-10",
            "capacity"=> "20"
        ];
        $respository->createClasses($input);
        $classes = $respository->getClasses();
        $class = $classes[0];
        $respository->bookClass($class);
        $this->assertEquals($class->capacity, "19");
    }

}