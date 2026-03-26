-- MySQL Database Export for HAWK Application

-- Create Database
CREATE DATABASE IF NOT EXISTS `hawk_db`;
USE `hawk_db`;

-- Create auth_user table
CREATE TABLE `auth_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL UNIQUE,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create teachers table
CREATE TABLE `teachers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `university_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `year_joined` int(4) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data into auth_user
INSERT INTO `auth_user` (`email`, `first_name`, `last_name`, `password`, `created_at`, `updated_at`) VALUES
('john@example.com', 'John', 'Doe', '$2y$10$YIxJKlKUvQOY0W2L.7Mqu.V8j5I8F1Mv5FZKq3K0I9u8F1J9F1J9.', NOW(), NOW()),
('jane@example.com', 'Jane', 'Smith', '$2y$10$YIxJKlKUvQOY0W2L.7Mqu.V8j5I8F1Mv5FZKq3K0I9u8F1J9F1J9.', NOW(), NOW()),
('robert@example.com', 'Robert', 'Johnson', '$2y$10$YIxJKlKUvQOY0W2L.7Mqu.V8j5I8F1Mv5FZKq3K0I9u8F1J9F1J9.', NOW(), NOW());

-- Insert sample data into teachers
INSERT INTO `teachers` (`user_id`, `university_name`, `gender`, `year_joined`, `specialization`, `created_at`, `updated_at`) VALUES
(1, 'KIIT University', 'Male', 2018, 'Computer Science', NOW(), NOW()),
(2, 'Delhi University', 'Female', 2019, 'Information Technology', NOW(), NOW()),
(3, 'Mumbai University', 'Male', 2020, 'Electronics Engineering', NOW(), NOW());
