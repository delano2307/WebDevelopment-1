-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 17 jan 2026 om 19:50
-- Serverversie: 12.1.2-MariaDB-ubu2404
-- PHP-versie: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `muscle_group` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `exercises`
--

INSERT INTO `exercises` (`id`, `name`, `muscle_group`, `created_at`) VALUES
(2, 'Chest Press', 'Chest', '2026-01-15 15:55:49'),
(3, 'Tricep Pushdown', 'Tricep', '2026-01-15 15:56:06'),
(4, 'Preacher curl (halter)', 'Bicep', '2026-01-15 19:41:24'),
(6, 'Calf raises', 'Leg', '2026-01-16 12:54:59'),
(7, 'Leg press (plates)', 'Leg', '2026-01-16 12:55:48'),
(8, 'Hamstring curl', 'Leg', '2026-01-16 12:56:01'),
(9, 'Leg extension', 'Leg', '2026-01-16 12:56:26'),
(10, 'Lat pulldown', 'Back', '2026-01-17 16:52:46'),
(11, 'Low row', 'Back', '2026-01-17 17:27:20'),
(12, 'Incline bench press (smith)', 'Chest', '2026-01-17 19:06:43'),
(13, 'Shoulder press (dumbell)', 'Shoulder', '2026-01-17 19:07:00'),
(14, 'Skull crusher (halter)', 'Tricep', '2026-01-17 19:07:19'),
(15, 'Pec deck fly', 'Chest', '2026-01-17 19:07:40'),
(16, 'Lateral raises (cable)', 'Shoulder', '2026-01-17 19:07:53'),
(17, 'Reverse fly', 'Shoulder', '2026-01-17 19:08:52'),
(18, 'Forearm curl', 'Forearm', '2026-01-17 19:10:02'),
(19, 'Hack squat', 'Leg', '2026-01-17 19:10:21'),
(20, 'Bicep curl (cable)', 'Bicep', '2026-01-17 19:10:41');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sets`
--

CREATE TABLE `sets` (
  `id` int(11) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `sets`
--

INSERT INTO `sets` (`id`, `workout_id`, `exercise_id`, `reps`, `weight`) VALUES
(6, 3, 3, 6, 867.00),
(8, 4, 7, 10, 80.00),
(9, 4, 7, 8, 160.00),
(10, 4, 7, 8, 160.00),
(11, 4, 7, 8, 180.00),
(12, 4, 8, 10, 30.00),
(13, 4, 8, 8, 35.00),
(14, 4, 8, 5, 40.00),
(15, 4, 8, 8, 37.50),
(16, 4, 9, 8, 45.00),
(17, 4, 9, 8, 50.00),
(18, 4, 9, 8, 50.00),
(19, 4, 6, 8, 120.00),
(20, 4, 6, 8, 140.00),
(21, 4, 6, 8, 140.00),
(22, 5, 7, 45, 80.00),
(23, 6, 2, 10, 40.00),
(24, 6, 2, 8, 85.00),
(25, 6, 3, 10, 25.00),
(26, 6, 3, 8, 40.00),
(27, 9, 4, 10, 5.00),
(28, 12, 4, 10, 50.00),
(29, 12, 4, 14, 14.00),
(30, 12, 10, 8, 15.00),
(31, 12, 10, 3, 33.00),
(32, 13, 3, 10, 25.00),
(33, 13, 3, 8, 42.50),
(34, 13, 3, 5, 45.00),
(35, 13, 3, 8, 40.00),
(36, 13, 12, 10, 40.00),
(37, 13, 12, 8, 65.00),
(38, 13, 12, 8, 70.00),
(39, 13, 12, 8, 70.00),
(40, 13, 13, 10, 16.00),
(41, 13, 13, 8, 24.00),
(42, 13, 13, 8, 26.00),
(43, 13, 13, 8, 26.00),
(44, 13, 14, 8, 30.00),
(45, 13, 14, 8, 30.00),
(46, 13, 14, 8, 30.00),
(47, 13, 15, 8, 30.00),
(48, 13, 15, 8, 32.50),
(49, 13, 15, 5, 35.00),
(50, 13, 16, 8, 7.50),
(51, 13, 16, 8, 7.50),
(52, 13, 16, 8, 7.50),
(53, 14, 3, 10, 25.00),
(54, 14, 3, 8, 40.00),
(55, 14, 3, 8, 40.00),
(56, 14, 3, 4, 47.50),
(57, 14, 12, 10, 40.00),
(58, 14, 12, 8, 65.00),
(59, 14, 12, 8, 70.00),
(60, 14, 12, 6, 72.50),
(61, 14, 13, 8, 16.00),
(62, 14, 13, 8, 26.00),
(63, 14, 13, 8, 26.00),
(64, 14, 13, 8, 28.00),
(65, 14, 14, 8, 35.00),
(66, 14, 14, 8, 35.00),
(67, 14, 14, 8, 35.00),
(68, 14, 15, 8, 35.00),
(69, 14, 15, 8, 35.00),
(70, 14, 15, 6, 37.50),
(71, 14, 16, 8, 7.50),
(72, 14, 16, 7, 10.00),
(73, 14, 16, 5, 10.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@admin.nl', '$2y$10$TXU5O4jYE/mxnqi03FIGGO9q19kymvdlbyDTRNRxVjYhJBt03zLAK', 'admin', '2026-01-15 19:20:02'),
(2, 'John Pork', 'John@Pork.com', '$2y$10$pya89yf5YD8F31WpcfKt7e15Iq83uNjv4uW0Gn5iwIl.kD9LVBgL.', 'user', '2026-01-15 12:25:20'),
(4, 'Delano', 'test@test.nl', '$2y$10$0DLZ/L.fcHxH.nRQqgfPBuLwOKwrjUErftIMTCYnXwSy1BXMnMLX6', 'user', '2026-01-14 21:54:50'),
(5, 'Delano', 'dsgabriel01@gmail.com', '$2y$10$M4MbGFdW1g/CrnxVMU1tGOUaxbh6t5yt566.KQnv0ezeAdJMGUYLO', 'user', '2026-01-15 19:47:20'),
(6, 'Gymbro', 'gymbro@gmail.com', '$2y$10$F2Em7mFtVjvruewuAJML6udpfntidDRklqspLHRk/1BLisBQg.h2y', 'user', '2026-01-17 19:11:20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `workouts`
--

INSERT INTO `workouts` (`id`, `name`, `user_id`, `date`, `created_at`) VALUES
(3, 'jk', 1, '2026-01-07', '2026-01-15 17:28:55'),
(4, 'Leg day', 1, '2026-01-15', '2026-01-16 12:57:04'),
(5, 'fhg', 1, '2026-01-06', '2026-01-17 12:03:39'),
(6, 'Push', 5, '2026-01-17', '2026-01-17 15:04:13'),
(7, 'j', 1, '2026-01-17', '2026-01-17 16:24:24'),
(8, 'k', 1, '2026-01-17', '2026-01-17 16:24:37'),
(9, 'hgfj', 1, '2026-01-17', '2026-01-17 16:25:32'),
(10, 'dfg', 1, '2026-01-07', '2026-01-17 16:25:50'),
(11, 'fgh', 1, '2025-12-11', '2026-01-17 16:26:14'),
(12, 'pull', 1, '2026-01-18', '2026-01-17 17:41:27'),
(13, 'Push day', 6, '2026-01-10', '2026-01-17 19:15:26'),
(14, 'Push day', 6, '2026-01-17', '2026-01-17 19:21:48');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sets`
--
ALTER TABLE `sets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_id` (`workout_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `sets`
--
ALTER TABLE `sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
