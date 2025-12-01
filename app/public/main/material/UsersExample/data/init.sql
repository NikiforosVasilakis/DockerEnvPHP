CREATE
DATABASE IF NOT EXISTS `users_demo`;

USE
`users_demo`;

CREATE TABLE `roles`
(
  `id`        INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL
);

INSERT INTO `roles` (`role_name`)
VALUES ('admin'),
       ('user');

CREATE TABLE `users`
(
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `username`   VARCHAR(50)  NOT NULL,
  `password`   VARCHAR(255) NOT NULL,              -- Securely hashed password
  `email`      VARCHAR(100) NOT NULL UNIQUE,
  `name`       VARCHAR(50)  NOT NULL,
  `surname`    VARCHAR(50)  NOT NULL,
  `birthdate`  DATE         NOT NULL,
  `gender`     ENUM('male', 'female') NOT NULL,
  `avatar`     VARCHAR(255)          DEFAULT NULL, -- Avatar filename
  `created_at` TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
  `status`     ENUM('active', 'inactive') DEFAULT 'active',
  `role_id`    INT          NOT NULL DEFAULT 2,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);

-- Use PHP to generate password hashes:
-- password_hash('securepass123', PASSWORD_BCRYPT)
INSERT INTO `users` (`username`, `password`, `email`, `name`, `surname`, `birthdate`, `gender`, `avatar`, `status`,
                     `role_id`)
VALUES ('adminuser', '$2y$10$HDoWoQUd8N/oAyDoyCpXLulODO7Hhb0KHjP95EkbThKkDaUaC154a', 'admin@example.com', 'Admin',
        'User', '1980-01-01', 'male', NULL, 'active', 1),    -- Password: securepass123
       ('johndoe', '$2y$10$Ll2HZhf2fUKUa/ztM3uQoOM1fFAsof5Ni6NpL0CSXRphlmh9mywCa', 'johndoe@example.com', 'John', 'Doe',
        '1990-05-15', 'male', 'johndoe_6746598eb3c1c.jpg', 'active', 2),            -- Password: johnpassword
       ('janedoe', '$2y$10$JRUVmegrM/v82xN2cwG/KOUorpTpxcfnRmmUjGC2LDzMKTzZtl0YS', 'janedoe@example.com', 'Jane', 'Doe',
        '1995-08-22', 'female', NULL, 'active', 2),          -- Password: janepassword
       ('alexsmith', '$2y$10$4TxLUSlUPTQZrpueQjILy.Upeowko8HWjy/dd47c.C.jUpgKyOcKC', 'alexsmith@example.com', 'Alex',
        'Smith', '1988-03-10', 'male', NULL, 'inactive', 2), -- Password: alexpassword
       ('lisajones', '$2y$10$GP3cs7KEeCcUTDEGoPRzsug0Rl5N2lG5crnSXC0CinyJOW4NY08pS', 'lisajones@example.com', 'Lisa',
        'Jones', '1992-12-01', 'female', NULL, 'active', 2); -- Password: lisapassword
