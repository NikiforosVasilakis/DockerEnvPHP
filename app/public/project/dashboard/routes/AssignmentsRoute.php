<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard/assignments");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard/assignments");
            exit;
        }

        abort(403);
    }, ['AuthMiddleware']],


    // TEACHER Assignments

    ['GET', '/project/teacher/dashboard/assignments',
        [AssignmentsController::class, 'teacherIndex'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    ['GET', '/project/teacher/dashboard/assignments/create',
        [AssignmentsController::class, 'create'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    ['POST', '/project/teacher/dashboard/assignments',
        [AssignmentsController::class, 'store'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],


    // STUDENT Assignments

    ['GET', '/project/student/dashboard/assignments',
        [AssignmentsController::class, 'studentIndex'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    ['GET', '/project/student/dashboard/assignments/submit',
        [AssignmentsController::class, 'submit'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    ['POST', '/project/student/dashboard/assignments/submit',
        [AssignmentsController::class, 'submitStore'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
];