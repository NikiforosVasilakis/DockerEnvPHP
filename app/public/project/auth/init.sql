DROP DATABASE IF EXISTS Univercity_DB;
CREATE DATABASE Univercity_DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE Univercity_DB;

-- =========================
-- Roles / Users
-- =========================

CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL,
    can_create TINYINT(1) DEFAULT 0,
    can_read   TINYINT(1) DEFAULT 1,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role_id    INT NOT NULL DEFAULT 2,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id) REFERENCES user_roles(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO user_roles (role_name, can_create, can_read, can_update, can_delete)
VALUES
    ('Student', 0, 1, 1, 0),
    ('Teacher', 1, 1, 1, 1),
    ('Admin',   1, 1, 1, 1);

-- =========================
-- Registration Codes
-- =========================

CREATE TABLE registration_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_code   VARCHAR(100) NOT NULL UNIQUE,
    role_id    INT NOT NULL,
    expires_at DATETIME NOT NULL,
    used       TINYINT(1) DEFAULT 0,
    CONSTRAINT fk_regcodes_role
        FOREIGN KEY (role_id) REFERENCES user_roles(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO registration_codes (reg_code, role_id, expires_at)
VALUES
    ('STUD2025', 1, '2027-12-31 23:59:59'),
    ('PROF2025', 2, '2027-12-31 23:59:59'),
    ('ADMN2025', 3, '2027-12-31 23:59:59');

-- =========================
-- Courses
-- Teachers create courses, students enroll
-- =========================

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    course_code VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_courses_teacher
        FOREIGN KEY (teacher_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_courses_teacher (teacher_id)
) ENGINE=InnoDB;

-- Student enrollments to courses
CREATE TABLE course_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    enrolled_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_enroll_course
        FOREIGN KEY (course_id) REFERENCES courses(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_enroll_student
        FOREIGN KEY (student_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    UNIQUE KEY uq_course_student (course_id, student_id),
    INDEX idx_enroll_student (student_id),
    INDEX idx_enroll_course (course_id)
) ENGINE=InnoDB;

-- =========================
-- Course Content
-- Teachers add content to courses
-- =========================

CREATE TABLE course_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    content_type ENUM('TEXT','LINK','FILE','VIDEO') NOT NULL DEFAULT 'TEXT',
    title VARCHAR(200) NOT NULL,
    body LONGTEXT NULL,          -- for TEXT content
    url  VARCHAR(2048) NULL,     -- for LINK/VIDEO
    file_path VARCHAR(1024) NULL,-- for FILE (store path or key)
    sort_order INT NOT NULL DEFAULT 0,
    is_visible TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_content_course
        FOREIGN KEY (course_id) REFERENCES courses(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    INDEX idx_content_course (course_id),
    INDEX idx_content_course_order (course_id, sort_order)
) ENGINE=InnoDB;

-- =========================
-- Assignments + Submissions + Grades
-- =========================

-- Teacher uploads/creates an assignment tied to a course
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    attachment_path VARCHAR(1024) NULL,  -- teacher file upload path/key
    max_points DECIMAL(6,2) NOT NULL DEFAULT 100.00,
    due_at DATETIME NULL,
    allow_late TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_assignment_course
        FOREIGN KEY (course_id) REFERENCES courses(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    INDEX idx_assign_course (course_id),
    INDEX idx_assign_due (due_at)
) ENGINE=InnoDB;

-- Student uploads a submission (optionally multiple attempts)
CREATE TABLE assignment_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT NOT NULL,
    student_id INT NOT NULL,
    attempt_no INT NOT NULL DEFAULT 1,
    submission_text LONGTEXT NULL,
    submission_path VARCHAR(1024) NULL,  -- uploaded file path/key
    submitted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('SUBMITTED','RESUBMITTED','LATE','DRAFT') NOT NULL DEFAULT 'SUBMITTED',
    CONSTRAINT fk_sub_assignment
        FOREIGN KEY (assignment_id) REFERENCES assignments(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_sub_student
        FOREIGN KEY (student_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    UNIQUE KEY uq_attempt (assignment_id, student_id, attempt_no),
    INDEX idx_sub_assignment (assignment_id),
    INDEX idx_sub_student (student_id),
    INDEX idx_submitted_at (submitted_at)
) ENGINE=InnoDB;

-- Grade table: teacher grades a specific submission
-- (Students can see grades; teacher can update grade/feedback)
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    submission_id INT NOT NULL UNIQUE,
    graded_by INT NOT NULL, -- teacher user id (or admin)
    points_awarded DECIMAL(6,2) NOT NULL,
    feedback TEXT NULL,
    graded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_grade_submission
        FOREIGN KEY (submission_id) REFERENCES assignment_submissions(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_grade_teacher
        FOREIGN KEY (graded_by) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_grade_teacher (graded_by),
    INDEX idx_grade_graded_at (graded_at)
) ENGINE=InnoDB;

-- =========================
-- Final Grades (UI form)
-- =========================

-- Lightweight table for overall/final grades captured via the dashboard form.
-- Keeps UI aligned without requiring an assignment submission reference.
CREATE TABLE final_grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course VARCHAR(200) NOT NULL,
    letter_grade VARCHAR(5) NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    feedback TEXT NULL,
    graded_by INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_final_grade_student
        FOREIGN KEY (student_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_final_grade_teacher
        FOREIGN KEY (graded_by) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    UNIQUE KEY uq_student_course (student_id, course),
    INDEX idx_final_grade_teacher (graded_by)
) ENGINE=InnoDB;