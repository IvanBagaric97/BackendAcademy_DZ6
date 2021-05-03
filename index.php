<?php

require_once './src/lib/global.php';

/*
$controller = null;

$controller = match (lib\get("action")) {
    "get" => new controller\RetrieveImageController(lib\get("id")),
    "add" => new controller\AddController($_POST),
    "delete" => new controller\DeleteController(lib\get("id")),
    default => new controller\IndexController(lib\get('letter')),
};

$controller -> doAction();
*/

try {
    \Dispatch\Dispatcher::getInstance()->dispatch();
} catch (\Routing\RoutingException $e) {
    lib\redirect(\Routing\Route::get('error')->generate(['code' => '404']));
} catch (Exception $e) {
    lib\redirect(\Routing\Route::get('error')->generate(['code' => '500']));
}