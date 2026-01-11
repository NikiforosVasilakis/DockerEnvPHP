<?php

namespace attributes;

use Attribute;

/**
 * Route Attribute
 * Defines the path for a route in a controller method.
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Route {
    public string $path;

    /**
     * Constructor for the Route attribute.
     *
     * @param string $path The path for the route (e.g., 'dashboard', 'users').
     */
    public function __construct(string $path) {
        $this->path = $path;
    }
}
