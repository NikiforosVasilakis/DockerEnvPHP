<?php
return [
    ['GET', '/project/dashboard/teachers',
        [TeachersController::class, 'index'],
        ['AuthMiddleware']
    ],
];
