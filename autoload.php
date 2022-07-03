<?php

include 'application/Helper.php';

function autoload($class_name)
{
    $array_paths = array(
        'Controllers',
        'Models'
    );

    foreach ($array_paths as $path) {
        $file = sprintf('application/%s/%s.php', $path, $class_name);

        if (is_file($file)) {
            include_once $file;
        }
    }

}

spl_autoload_register('autoload');