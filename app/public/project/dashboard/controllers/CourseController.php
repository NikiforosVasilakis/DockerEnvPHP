<?php

class CourseController
{
    //teacher
    public function teacherIndex(): void
    {
        require BASE_PATH . '/views/Courses/teacher/index.php';
    
    }

    public function create(): void
    {
        require BASE_PATH . '/views/Courses/teacher/create.php';
    
    }

    
    public function edit(): void
    {
        require BASE_PATH . '/views/Courses/teacher/edit.php';
    
    }
    //student
    public function studentIndex(): void
    {
        require BASE_PATH . '/views/Courses/student/index.php';
    
    }
    public function show(): void
    {
        require BASE_PATH . '/views/Courses/student/show.php';
    
    }
}