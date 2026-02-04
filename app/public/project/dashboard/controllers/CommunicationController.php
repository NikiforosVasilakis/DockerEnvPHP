<?php

class CommunicationController
{
    public function teacherCommunication_T(): void
    {
        require BASE_PATH . '/views/communication/teachers/teachers.php';
    } 

    public function studentCommunication_T(): void
    {
        require BASE_PATH . '/views/communication/teachers/students.php';
    }

    public function studentCommunication_S(): void
    {
        require BASE_PATH . '/views/communication/students/students.php';
    }
    
    public function teacherCommunication_S(): void
    {
        require BASE_PATH . '/views/communication/students/teachers.php';
    }
}