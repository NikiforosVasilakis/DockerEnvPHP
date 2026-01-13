<?php

class AssignmentsController
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

    //student
    public function studentIndex(): void
    {
        echo 'hello from s';
    
    }
    public function submit(): void
    {
        echo 'hello from s submit';
    
    }
}