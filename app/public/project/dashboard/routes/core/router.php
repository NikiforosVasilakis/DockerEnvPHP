<?php
declare(strict_types=1);

class Router
{
    public function __construct(private array $routes) {}

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);


        foreach ($this->routes as $route) {
            [$routeMethod, $routePath, $handler, $middleware] = $route;

            if ($routeMethod === $method && $routePath === $path) {

                // middleware
                foreach ($middleware as $mw) {

                    // supports "RoleMiddleware:student"
                    if (is_string($mw) && str_contains($mw, ':')) {
                        [$mwClass, $param] = explode(':', $mw, 2);
                        (new $mwClass())->handle($param);
                        continue;
                    }

                    (new $mw())->handle();
                }

                // handler: closure
                if (is_callable($handler)) {
                    $handler();
                    return;
                }

                // handler: [Class::class, 'method']
                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    (new $class())->$action();
                    return;
                }

                abort(500);
            }
        }

        abort(404);
    }
}