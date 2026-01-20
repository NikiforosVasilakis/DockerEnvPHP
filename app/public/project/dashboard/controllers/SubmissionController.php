<?php

class SubmissionController
{
    //teacher
    public function teacherIndex(): void
    {
        require BASE_PATH . '/dashboard/views/submissions/teacher/index.php'
    
    }

    public function create(): void
    {
        require BASE_PATH . '/dashboard/views/submissions/teacher/create.php'
    
    }
    public function edit(): void
    {
        require BASE_PATH . '/dashboard/views/submissions/teacher/edit.php'
    
    }
    //student
    public function studentIndex(): void
    {
        require BASE_PATH . '/dashboard/views/submissions/teacher/index.php'
    
    }

    public function Studentedit(): void
    {
        require BASE_PATH . '/dashboard/views/submissions/teacher/edit.php'
    
    }
}