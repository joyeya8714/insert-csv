<?php
define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));
require_once(ROOT . 'Controller/Controller.php');

$params = empty($_GET) ? [] : explode('/', $_GET['p']);

if (!empty($params) && !empty($params[0])) {
    $controller = ucfirst($params[0]) . 'Controller';
    $action = $params[1] ?? 'index';
    require_once(ROOT . 'Controller/' . $controller . '.php');
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "La page recherchée n'existe pas";
    }
} else {
    require_once(ROOT . 'Controller/AppelController.php');
    $controller = new AppelController();
    $controller->index();
}