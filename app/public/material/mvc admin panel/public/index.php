<?php

// Autoload classes
spl_autoload_register(static function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load routes
$routes = include __DIR__ . '/../routes/web.php';

// Get the requested page from the query string
$page = $_GET['route'] ?? 'maincontroller/index'; // Default to MainController::index

// Parse the page into controller and method
[$controllerName, $methodName] = explode('/', $page) + [null, null];

// Normalize the controller class name
$controllerClass = 'controllers\\' . ucfirst($controllerName);

// Check if the controller exists
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    // Check if the method exists in the controller
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
        exit;
    }
}

// 404 Error if no route matches
http_response_code(404);
// Render the 404 view through the main layout
$view = 'errors/404';
$title = 'Error';
include __DIR__ . '/../layouts/main.php';
