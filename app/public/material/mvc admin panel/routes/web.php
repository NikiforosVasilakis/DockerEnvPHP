<?php

use attributes\Route;

/**
 * Discover all controller classes in the given directory.
 *
 * @param string $controllerPath Path to the controllers directory.
 * @param string $namespace Namespace for the controllers.
 * @return array List of fully-qualified class names for all controllers.
 */
function discoverControllers(string $controllerPath, string $namespace): array {
    $controllers = [];
    foreach (glob($controllerPath . '/*.php') as $file) {
        $className = $namespace . '\\' . basename($file, '.php');
        if (class_exists($className)) {
            $controllers[] = $className;
        }
    }
    return $controllers;
}

/**
 * Register routes dynamically using reflection.
 *
 * @param array $controllers List of controller class names.
 * @return array Mapped routes with query-based paths.
 * @throws ReflectionException
 */
function registerRoutes(array $controllers): array {
    $routes = [];

    foreach ($controllers as $controller) {
        $reflectionClass = new \ReflectionClass($controller);

        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $attributes = $method->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                $route = $attribute->newInstance();
                $routes[$route->path] = [$controller, $method->getName()];
            }
        }
    }

    return $routes;
}

// Automatically discover all controllers in the controllers directory
$controllerPath = __DIR__ . '/../controllers'; // Path to the controllers folder
$namespace = 'controllers'; // Namespace for controllers
$controllers = discoverControllers($controllerPath, $namespace);

// Register routes dynamically
try {
    return registerRoutes($controllers);
} catch (ReflectionException $e) {
    throw new RuntimeException('Failed to register routes: ' . $e->getMessage());
}
