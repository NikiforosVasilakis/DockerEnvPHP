<?php
class TeacherDashboardController{

    public function index(): void
    {
        require BASE_PATH . '/views/Dashboard/teacher/dashboard.php';
    }
}