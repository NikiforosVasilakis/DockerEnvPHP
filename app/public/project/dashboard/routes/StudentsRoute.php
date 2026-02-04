<?php
return [
    ['GET', '/project/dashboard/students',
        [StudentsController::class, 'index'],
        ['AuthMiddleware']
    ],
];
