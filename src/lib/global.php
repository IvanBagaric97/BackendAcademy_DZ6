<?php

require_once dirname(__FILE__) . '/htmlLibrary.php';
require_once dirname(__FILE__) . '/functions.php';

$base = __DIR__ . "/../../";

spl_autoload_register(function($classname) {
    $fileName = "./src/" .
        str_replace("\\", "/", $classname) .
        ".php";
    #echo $fileName;
    if (!is_readable($fileName)) {
        return false ;
    }
    require_once $fileName;
    return true;
}
);

// require composer's autoloader
require_once $base . "vendor/autoload.php";

// load routes
\Routing\DefaultRoute::registerFromYML($base . "conf/routes.yaml");