<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard/grades");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard/grades");
            exit;
        }

        abort(403);
    }, ['AuthMiddleware']],


    // TEACHER grades

    ['GET', '/project/teacher/dashboard/grades',
        [GradeController::class, 'teacherIndex'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    ['POST', '/project/teacher/dashboard/grades',
        [GradeController::class, 'store'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],


    // STUDENT grades

    ['GET', '/project/student/dashboard/grades',
        [GradeController::class, 'studentIndex'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    ['POST', '/project/student/dashboard/grades/',
        [GradeController::class, 'submitStore'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
];