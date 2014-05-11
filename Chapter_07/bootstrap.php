<?php
ini_set('memory_limit', '512M');
error_reporting( E_ALL | E_STRICT );

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

spl_autoload_register('loadClass');

function loadClass($className)
{
    $base_dir = __DIR__ . '/src/';
    $test_dir = __DIR__ . '/tests/';

    set_include_path($base_dir . PATH_SEPARATOR . $test_dir);

    $file = str_replace('\\', '/', $className) . '.php';

    if(file_exists($file))
    {
        require_once $file;
    }
}