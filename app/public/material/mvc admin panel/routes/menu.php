<?php

use controllers\MainController;
use controllers\BookController;

return [
    [MainController::class, 'index', 'Dashboard'],
    [BookController::class, 'list'],
    [BookController::class, 'add'],
];
