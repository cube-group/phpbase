<?php
/**
 * Registers an autoload for all the classes in libs\*
 */
require dirname(__DIR__) . "/vendor/autoload.php";
spl_autoload_register(function ($className) {
    $namespace = 'libs';

    if (strpos($className, $namespace) === 0) {
        $className = str_replace($namespace, '', $className);
        $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require($fileName);
        }
    }
});
