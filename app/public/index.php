<?php
 /* See the documentation for FastRoute for more information: https://github.com/nikic/FastRoute */

session_start();

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {

    //login & register
    $r->addRoute('GET', '/', ['App\Controllers\AuthController', 'showLogin']);
    
    $r->addRoute('GET',  '/login',    ['App\Controllers\AuthController', 'showLogin']);
    $r->addRoute('POST', '/login',    ['App\Controllers\AuthController', 'login']);
    $r->addRoute('GET',  '/register', ['App\Controllers\AuthController', 'showRegister']);
    $r->addRoute('POST', '/register', ['App\Controllers\AuthController', 'register']);
    $r->addRoute('POST', '/logout',   ['App\Controllers\AuthController', 'logout']);

    $r->addRoute('GET',  '/dashboard',['App\Controllers\DashboardController', 'index']);

    //workouts
    $r->addRoute('GET',  '/workouts',         ['App\Controllers\WorkoutController', 'index']);
    $r->addRoute('GET',  '/workouts/create',  ['App\Controllers\WorkoutController', 'create']);
    $r->addRoute('POST', '/workouts',         ['App\Controllers\WorkoutController', 'store']);
    $r->addRoute('GET',  '/workouts/{id:\d+}',['App\Controllers\WorkoutController', 'show']);

    $r->addRoute('POST', '/workouts/{id:\d+}/delete', ['App\Controllers\WorkoutController', 'delete']);
    $r->addRoute('GET',  '/workouts/{id:\d+}/edit',   ['App\Controllers\WorkoutController', 'edit']);
    $r->addRoute('POST', '/workouts/{id:\d+}/update', ['App\Controllers\WorkoutController', 'update']);

    //sets
    $r->addRoute('POST', '/sets', ['App\Controllers\SetController', 'store']);

    $r->addRoute('GET',  '/sets/{id:\d+}/edit',     ['App\Controllers\SetController', 'edit']);
    $r->addRoute('POST', '/sets/{id:\d+}/update',   ['App\Controllers\SetController', 'update']);
    $r->addRoute('POST', '/sets/{id:\d+}/delete',   ['App\Controllers\SetController', 'delete']);

    //exercises
    $r->addRoute('GET',  '/exercises', ['App\Controllers\ExerciseController', 'index']);

    //exercises (admin only)
    $r->addRoute('GET',  '/exercises/create',         ['App\Controllers\ExerciseController', 'create']);
    $r->addRoute('POST', '/exercises',                ['App\Controllers\ExerciseController', 'store']);
    $r->addRoute('GET',  '/exercises/{id:\d+}/edit',  ['App\Controllers\ExerciseController', 'edit']);
    $r->addRoute('POST', '/exercises/{id:\d+}/update',['App\Controllers\ExerciseController', 'update']);
    $r->addRoute('POST', '/exercises/{id:\d+}/delete',['App\Controllers\ExerciseController', 'delete']);

    //progress
    $r->addRoute('GET',  '/progress',     ['App\Controllers\ProgressController', 'index']);
    $r->addRoute('GET',  '/api/progress', ['App\Controllers\ApiController', 'progress']);   

});

/**
 * Get the request method and URI from the server variables and invoke the dispatcher.
 */
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');

// Optional: treat /index.php as /
if ($uri === '/index.php') {
    $uri = '/';
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

/**
 * Switch on the dispatcher result and call the appropriate controller method if found.
 */
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo 'Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        // $routeInfo[1] is the handler we provided in addRoute: [ControllerClass, methodName]
        $handler = $routeInfo[1];
        $vars = $routeInfo[2] ?? [];

        [$controllerClass, $method] = $handler;

        if (!class_exists($controllerClass)) {
            throw new RuntimeException("Controller not found: {$controllerClass}");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Method not found: {$controllerClass}::{$method}");
        }

        // Pass dynamic route vars to controller method (e.g. ['name' => 'dan-the-man'])
        $result = empty($vars) ? $controller->$method() : $controller->$method($vars);

        // If controller returns a string (HTML), echo it
        if (is_string($result)) {
            echo $result;
        }

        break;
}
