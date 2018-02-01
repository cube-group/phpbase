<?php
/**
 * Registers an autoload for all the classes in Gregwar
 */
spl_autoload_register(function ($className) {
    $namespace = 'Gregwar';
    if (strpos($className, $namespace) === 0) {

        //Prevent multiple complete namespace name
        //$className = str_replace($namespace,'',$className);
        $className = substr($className, strlen($namespace));

        $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

        if (file_exists($fileName)) {
            require($fileName);
        }
    }
});