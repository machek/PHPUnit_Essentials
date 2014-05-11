<?php
spl_autoload_register('loadClass');

function loadClass($className)
{
    $file = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className . '.php';
    if(file_exists($file))
        require_once $file;
}
