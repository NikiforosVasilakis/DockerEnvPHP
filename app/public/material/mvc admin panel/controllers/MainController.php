<?php

namespace controllers;

use attributes\Route;

/**
 * MainController
 * Handles the core routes for the admin panel.
 */
class MainController extends BaseController {
    public const VIEWS = [
        'dashboard' => ['view' => 'main/dashboard', 'title' => 'Dashboard'],
    ];

    #[Route('/')]
    public function index(): void {
        $this->dashboard();
    }

    #[Route('/dashboard')]
    public function dashboard(): void {
        $this->render(self::VIEWS['dashboard']);
    }
}
