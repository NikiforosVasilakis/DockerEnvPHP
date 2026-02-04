<?php
class AuthMiddleware {
    public function handle(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/project/auth/login.php");
            exit;
        }
    }
}