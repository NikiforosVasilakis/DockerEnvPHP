<?php
class RoleMiddleware {
    public function handle(string $role): void {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? null) !== $role) {
            abort(403);
        }
    }
}