CREATE DATABASE IF NOT EXISTS movies;
USE movies;

INSERT IGNORE INTO `user` (`id`, `username`, `password`, `email`, `is_active`, `roles`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin', '$2y$13$7W.JDI5BPFtwS.jrIiOG/evgvoPHvYfNqQNfzYy4fDqfoU8RL47YS', 'user@gmail.com', 1, 'ROLE_USER', '2022-07-19 00:45:55', NULL, 1, NULL);