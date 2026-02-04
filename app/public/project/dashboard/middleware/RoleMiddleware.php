<?php
class RoleMiddleware {
    public function handle(string $role): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $sessionUser = $_SESSION['user'] ?? null;

        // Accept both string role ("student"/"teacher") and numeric role_id (1 student, 2 teacher)
        $roleMatches = false;
        if ($sessionUser) {
            $roleMatches = ($sessionUser['role'] ?? null) === $role;

            if (!$roleMatches && isset($sessionUser['role_id'])) {
                $map = [1 => 'student', 2 => 'teacher', 3 => 'admin'];
                $roleMatches = ($map[$sessionUser['role_id']] ?? null) === $role;
            }
        }

        if (!$roleMatches) {
            abort(403);
        }
    }
}