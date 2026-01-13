<?php

class CourseController
{
    //teacher
    public function teacherIndex(): void
    {
        echo 'hello from t index';
    
    }

    public function create(): void
    {
        echo 'hello from t create';
    
    }
    public function edit(): void
    {
        echo 'hello from t edit';
    
    }
    //student
    public function studentIndex(): void
    {
        echo 'hello from s edit';
    
    }
    public function show(): void
    {
        echo 'hello from s show';
    
    }
}