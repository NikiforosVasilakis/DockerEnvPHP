DROP DATABASE IF EXISTS Univercity_DB;
CREATE DATABASE Univercity_DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE Univercity_DB;

CREATE TABLE user_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL,
    can_create TINYINT(1) DEFAULT 0,
    can_read TINYINT(1) DEFAULT 1,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL DEFAULT 2,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES user_roles(id)
);

INSERT INTO user_roles (role_name, can_create, can_read, can_update, can_delete)
VALUES
    ('Student', 0, 1, 1, 0),
    ('Teacher', 1, 1, 1, 1);


CREATE TABLE registration_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_code VARCHAR(100) NOT NULL UNIQUE,
    role_id INT NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    FOREIGN KEY (role_id) REFERENCES user_roles(id)
);

INSERT INTO registration_codes (reg_code, role_id)
VALUES
    ('STUD2025', 1),
    ('PROF2025', 2);

