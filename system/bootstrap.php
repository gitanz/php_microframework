<?php


define('BASE_DIR', __DIR__."/..");

ini_set('display_errors', 1);

error_reporting(E_ALL);

spl_autoload_register('autoload');

function autoload($class)
{
    $relative_path = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    include BASE_DIR."/$relative_path.php";
}