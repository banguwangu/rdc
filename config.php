<?php
	define('BASE_DIR', dirname(__DIR__));
    define('sp', DIRECTORY_SEPARATOR);
    define("SCHEME", $_SERVER['REQUEST_SCHEME']);
    define("HOST", $_SERVER['HTTP_HOST']);
    define('DOMAIN', SCHEME . '://' . HOST . '/rdc/');

    spl_autoload_register(function ($class) {
        $file = __DIR__ .sp . str_replace('\\', sp, $class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    });