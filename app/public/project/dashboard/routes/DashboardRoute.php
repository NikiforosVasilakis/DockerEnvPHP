<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard");
            exit;
        }
        abort(403);

    }, ['AuthMiddleware']],

    ['GET', '/project/student/dashboard',
        [StudentDashboardController::class, 'index'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    ['GET', '/project/teacher/dashboard',
        [TeacherDashboardController::class, 'index'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],
];