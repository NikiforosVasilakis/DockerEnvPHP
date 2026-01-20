<?php

class AssignmentsController
{
    //teacher
    public function teacherIndex(): void
    {
        require BASE_PATH . '/views/assignments/teacher/index.php';
    
    }

    public function create(): void
    {
        require BASE_PATH . '/views/assignments/teacher/create.php';
    
    }

    //student
    public function studentIndex(): void
    {
        require BASE_PATH . '/views/assignments/student/index.php';
    
    }
    public function submit(): void
    {
        require BASE_PATH . '/views/assignments/student/submit.php';
    
    }
}