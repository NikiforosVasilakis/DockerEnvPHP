<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard/communication");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard/communication");
            exit;
        }
        abort(403);

    }, ['AuthMiddleware']],
 
    // Friendly aliases for role-based communication landing pages
    ['GET', '/project/student/dashboard/communication',
        [CommunicationController::class, 'studentCommunication_S'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
    ['GET', '/project/teacher/dashboard/communication',
        [CommunicationController::class, 'studentCommunication_T'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    ['GET', '/project/teacher/dashboard/TeacherCommunication',
        [CommunicationController::class, 'teacherCommunication_T'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Explicit student communication alias for teacher dashboard
    ['GET', '/project/teacher/dashboard/communication/student',
        [CommunicationController::class, 'studentCommunication_T'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],
    ['GET', '/project/teacher/dashboard/StudentCommunication',
        [CommunicationController::class, 'studentCommunication_T'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    ['GET', '/project/student/dashboard/StudentCommunication',
        [CommunicationController::class, 'studentCommunication_S'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
    ['GET', '/project/student/dashboard/TeacherCommunication',
        [CommunicationController::class, 'teacherCommunication_S'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
];