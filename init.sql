--
-- Create DATABASE `movies`
--
CREATE DATABASE IF NOT EXISTS movies;
USE movies;
-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
    `Id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `casts` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
    `release_date` date NOT NULL,
    `director` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ratings` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
    `Id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `is_active` tinyint(1) NOT NULL,
    `roles` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime DEFAULT NULL,
    `created_by` int(11) NOT NULL,
    `updated_by` int(11) DEFAULT NULL,
    UNIQUE(email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2;

INSERT IGNORE INTO `user` (`id`, `username`, `password`, `email`, `is_active`, `roles`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin', '$2y$13$7W.JDI5BPFtwS.jrIiOG/evgvoPHvYfNqQNfzYy4fDqfoU8RL47YS', 'user@gmail.com', 1, 'ROLE_USER', '2022-07-19 00:45:55', NULL, 1, NULL);
