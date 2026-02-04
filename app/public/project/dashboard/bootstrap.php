<?php
declare(strict_types=1);

require_once BASE_PATH . '/middleware/AuthMiddleware.php';
require_once BASE_PATH . '/middleware/RoleMiddleware.php';


// 1) loadz DB (if needed)
// '/auth/connect.php';

//defining base url

//define('BASE_URL', '/app/public/project');
//header("Location: " . BASE_URL . "/dashboard/dashboard.php");

// 2) autoload BASE_PATH = /app/public/project/dashboard
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . "/controllers/$class.php",
        BASE_PATH . "/models/$class.php",
        BASE_PATH . "/middleware/$class.php",
        BASE_PATH . "/routes/$class.php",
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Simple abort helper
function abort(int $code = 404): void {
    http_response_code($code);
    echo "Error $code";
    exit;
}

//all routes
$routes = [];

$routes = array_merge($routes, require BASE_PATH . '/routes/DashboardRoute.php');
$routes = array_merge($routes, require BASE_PATH . '/routes/CoursesRoute.php');
$routes = array_merge($routes, require BASE_PATH . '/routes/AssignmentsRoute.php');
$routes = array_merge($routes, require BASE_PATH . '/routes/GradesRoute.php');
$routes = array_merge($routes, require BASE_PATH . '/routes/SubmissionsRoute.php');
$routes = array_merge($routes, require BASE_PATH . '/routes/CommunicationRoute.php');


// Load Router class
require BASE_PATH . '/routes/core/Router.php';

// Dispatch
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);