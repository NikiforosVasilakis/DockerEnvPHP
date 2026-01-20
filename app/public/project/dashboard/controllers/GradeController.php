<?php
class GradeController{
    public function teacherIndex(): void
        {
            require BASE_PATH . '/views/grades/teacher/index.php';
        
        }
        //student
        public function studentIndex(): void
        {
            require BASE_PATH . '/views/grades/student/index.php';
        
        }

}