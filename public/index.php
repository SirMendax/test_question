<?php
/*
 * =====================================================
 * ||            Include base app config              ||
 * ||            CONST DEBUG AND INCLUDE              ||
 * ||             DB_CONFIG AND AUTOLOAD              ||
 * =====================================================
 */
include ROOT . '/config/config.php';

/*
 * =====================================================
 * ||      Initialization foundamental CLASSES:       ||
 * ||    REQUEST, RESPONSE AND EXCEPTION HANDLER      ||
 * =====================================================
 */
$request = new \core\Request();
$response = new \core\Response();
$handler = new \src\Http\Handler\HandlerException();

/*
 * =====================================================
 * ||        Added base header for response           ||
 * =====================================================
 */
$response->setHeader('Access-Control-Allow-Origin: *');
$response->setHeader("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
$response->setHeader('Content-Type: application/json; charset=UTF-8');

/*
 * =====================================================
 * ||        Initialization routing system            ||
 * =====================================================
 */
$router = new \core\Router($request->getUrl(), $request->getMethod());

/*
 * =====================================================
 * ||        Include files with all routes API        ||
 * =====================================================
 */
require ROOT . '/routes/routes.php';

/*
 * =====================================================
 * ||             Launch routing system               ||
 * =====================================================
 */
$router->run();
