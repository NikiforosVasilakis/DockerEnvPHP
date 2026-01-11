<?php

namespace controllers;

abstract class BaseController {
    /**
     * Render a view.
     *
     * @param array $data Contains 'view' and 'title' keys for rendering.
     * @param array $additionalData Additional data to pass to the view.
     * @return void
     */
    protected function render(array $data, array $additionalData = []): void {
        extract(array_merge($data, $additionalData));
        include_once __DIR__ . '/../layouts/main.php';
    }
}
