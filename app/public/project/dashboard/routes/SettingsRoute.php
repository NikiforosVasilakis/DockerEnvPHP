<?php
return [
    ['GET', '/project/student/settings',
        [SettingsController::class, 'studentIndex'],
        ['AuthMiddleware', 'RoleMiddleware:student']
    ],
];
