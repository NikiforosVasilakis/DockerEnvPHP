-- ============================================================
-- DATABASE INITIALISATION
-- ============================================================

DROP DATABASE IF EXISTS demo_db;
CREATE DATABASE demo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE demo_db;

-- ============================================================
-- USER ROLES TABLE
-- ============================================================

CREATE TABLE user_roles (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            role_name VARCHAR(100) NOT NULL,
                            can_create TINYINT(1) DEFAULT 0,
                            can_read TINYINT(1) DEFAULT 1,
                            can_update TINYINT(1) DEFAULT 0,
                            can_delete TINYINT(1) DEFAULT 0
);

-- Insert 2 roles
INSERT INTO user_roles (role_name, can_create, can_read, can_update, can_delete)
VALUES
    ('full_access', 1, 1, 1, 1),
    ('editor',       0, 1, 1, 0);

-- ============================================================
-- USERS TABLE (EMPTY)
-- ============================================================

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       first_name VARCHAR(100) NOT NULL,
                       last_name VARCHAR(100) NOT NULL,
                       email VARCHAR(150) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       phone VARCHAR(50),
                       age INT,
                       city VARCHAR(100),
                       role_id INT NOT NULL DEFAULT 2,
                       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                       FOREIGN KEY (role_id) REFERENCES user_roles(id)
);

-- (Users remain empty as requested)

-- ============================================================
-- REGISTRATION CODES TABLE
-- ============================================================

CREATE TABLE registration_codes (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    reg_code VARCHAR(100) NOT NULL UNIQUE,
                                    role_id INT NOT NULL,
                                    expires_at DATETIME NOT NULL,
                                    used TINYINT(1) DEFAULT 0,
                                    FOREIGN KEY (role_id) REFERENCES user_roles(id)
);

-- Insert demo registration codes (valid for 24 hours)

INSERT INTO registration_codes (reg_code, role_id, expires_at)
VALUES
    ('FULLACCESS123', 1, DATE_ADD(NOW(), INTERVAL 1 DAY)),
    ('EDITOR456',     2, DATE_ADD(NOW(), INTERVAL 1 DAY)),
    ('EDITOR789',     2, DATE_ADD(NOW(), INTERVAL 1 DAY));

-- ============================================================
-- ARTICLES TABLE
-- ============================================================

CREATE TABLE articles (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          title VARCHAR(255) NOT NULL,
                          short_description VARCHAR(500),
                          author VARCHAR(150),
                          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                          category VARCHAR(100),
                          tags VARCHAR(255),
                          body TEXT
);

-- ============================================================
-- INSERT DEMO ARTICLES (WITH HTML CONTENT)
-- ============================================================

INSERT INTO articles
(title, short_description, author, category, tags, body)
VALUES
    (
        'The Rise of Modern Web Development',
        'How modern frameworks changed the way we build websites.',
        'John Smith',
        'Technology',
        'web, javascript, frontend',
        '<h2>The Modern Web</h2>
        <p>Modern frameworks like <strong>React</strong>, <em>Vue</em> and <strong>Angular</strong>
        have redefined how the web is built.</p>
        <p>Developers now reuse <strong>components</strong> and follow clean architecture patterns.</p>'
    ),
    (
        'Healthy Living in a Busy World',
        'Simple tips to improve your health even with limited free time.',
        'Maria Papadopoulou',
        'Health',
        'wellness, lifestyle',
        '<p>Even with a demanding lifestyle, good habits can be built easily.</p>
        <ul>
            <li>Walk more often</li>
            <li><strong>Stay hydrated</strong></li>
            <li><u>Sleep at least 7 hours</u></li>
        </ul>'
    ),
    (
        'Beginner’s Guide to Personal Finance',
        'Understanding money management in your twenties.',
        'Peter Johnson',
        'Finance',
        'money, saving, budgeting',
        '<p>Personal finance begins with understanding your spending patterns.</p>
        <p>Build an <em>emergency fund</em> and avoid unnecessary debt.</p>'
    ),
    (
        'Exploring the Greek Islands',
        'Top destinations to visit this summer.',
        'Eleni Georgiou',
        'Travel',
        'greece, islands, holidays',
        '<h3>Aegean Paradise</h3>
        <p>From Santorini to Paros, the Greek islands offer unmatched beauty.</p>'
    ),
    (
        'How to Stay Motivated All Year',
        'Psychological ideas to boost your motivation.',
        'Nikos Adam',
        'Self-Improvement',
        'motivation, productivity',
        '<p>Motivation is unreliable—systems are not.</p>
        <p>Break big goals into <strong>small daily tasks</strong>.</p>'
    ),
    (
        'Understanding Artificial Intelligence',
        'A beginner-friendly introduction to AI.',
        'Sophia Andreou',
        'Technology',
        'ai, machine learning',
        '<h3>What Is AI?</h3>
        <p>Artificial Intelligence allows machines to perform tasks traditionally requiring human intelligence.</p>'
    );

-- ============================================================
-- DONE
-- ============================================================