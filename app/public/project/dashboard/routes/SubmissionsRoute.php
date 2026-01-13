<?php
return [
    ['GET', '/project/dashboard/dashboard.php', function() {
        $role = $_SESSION['user']['role'] ?? null;

        if ($role === 'student') {
            header("Location: " . BASE_URL . "/project/student/dashboard/submissions");
            exit;
        }
        if ($role === 'teacher') {
            header("Location: " . BASE_URL . "/project/teacher/dashboard/submissions");
            exit;
        }
        abort(403);

    }, ['AuthMiddleware']],


    /**
     * TEACHER submissions
     */

    // Teacher submissions list (index)
    ['GET', '/project/teacher/dashboard/submissions',
        [submissionController::class, 'teacherIndex'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher create submissions
    ['GET', '/project/teacher/dashboard/submissions/create',
        [submissionController::class, 'create'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher create action (store)
    ['POST', '/project/teacher/dashboard/submissions/submissions',
        [submissionController::class, 'store'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher edit submissions
    ['GET', '/project/teacher/dashboard/submissions/edit',
        [submissionController::class, 'edit'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],

    // Teacher edit action (update)
    ['POST', '/project/teacher/dashboard/submissions/update',
        [submissionController::class, 'update'],
        ['AuthMiddleware', 'RoleMiddleware:teacher']
    ],


    //StudentCources

    // Student courses list (index)
    ['GET', '/project/student/dashboard/submissions',
        [submissionController::class, 'studentIndex'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    // Teacher create submissions
    ['GET', '/project/student/dashboard/submissions/create',
        [submissionController::class, 'Studentcreate'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    // Teacher create action (store)
    ['POST', '/project/student/dashboard/submissions/submissions',
        [submissionController::class, 'store'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    // Teacher edit submissions
    ['GET', '/project/student/dashboard/submissions/edit',
        [submissionController::class, 'Studentedit'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

    // Teacher edit action (update)
    ['POST', '/project/student/dashboard/submissions/update',
        [submissionController::class, 'update'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],

];
