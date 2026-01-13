<?php
class AuthMiddleware {
    public function handle(): void {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/auth/login.php");
            exit;
        }
    }
}