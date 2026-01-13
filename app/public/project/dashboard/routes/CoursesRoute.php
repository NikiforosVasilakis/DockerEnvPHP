<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard/cources");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard/cources");
            exit;
        }
        abort(403);

    }, ['AuthMiddleware']],


    /**
     * TEACHER COURSES
     */

    // Teacher courses list (index)
    ['GET', '/project/teacher/dashboard/cources',
        [CourseController::class, 'teacherIndex'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher create page
    ['GET', '/project/teacher/dashboard/cources/create',
        [CourseController::class, 'create'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher create action (store)
    ['POST', '/project/teacher/dashboard/cources/courses',
        [CourseController::class, 'store'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher edit page
    ['GET', '/project/teacher/dashboard/cources/edit',
        [CourseController::class, 'edit'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher edit action (update)
    ['POST', '/project/teacher/dashboard/cources/update',
        [CourseController::class, 'update'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],


    //StudentCources

    // Student courses list (index)
    ['GET', '/project/student/dashboard/courses',
        [CourseController::class, 'studentIndex'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    // Student view single course
    ['GET', '/project/student/dashboard/courses/views',
        [CourseController::class, 'show'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
];
