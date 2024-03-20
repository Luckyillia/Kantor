-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 06:31 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantor`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kurs`
--

CREATE TABLE `kurs` (
  `id` int(11) NOT NULL,
  `waluta_id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `kurs` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kurs`
--

INSERT INTO `kurs` (`id`, `waluta_id`, `data`, `kurs`) VALUES
(1, 1, '2024-03-18', 3.9528),
(2, 2, '2024-03-18', 4.3086),
(3, 3, '2024-03-18', 0.1014),
(4, 4, '2024-03-18', 2.9203),
(5, 5, '2024-03-18', 0.026492),
(6, 1, '2024-03-19', 3.9528),
(7, 2, '2024-03-19', 4.3086),
(8, 3, '2024-03-19', 0.1014),
(9, 4, '2024-03-19', 2.9203),
(10, 5, '2024-03-19', 0.026492),
(11, 1, '2024-03-20', 3.9866),
(12, 2, '2024-03-20', 4.3201),
(13, 3, '2024-03-20', 0.1019),
(14, 4, '2024-03-20', 2.9363),
(15, 5, '2024-03-20', 0.026455);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `portfel`
--

CREATE TABLE `portfel` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `waluta_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfel`
--

INSERT INTO `portfel` (`id`, `user_id`, `waluta_id`, `amount`) VALUES
(6, 3, 1, 0),
(7, 3, 2, 28.55),
(8, 3, 3, 0),
(9, 3, 4, 0),
(10, 3, 5, 1283.41),
(11, 1, 1, 0),
(12, 1, 2, 12.5),
(13, 1, 3, 0),
(14, 1, 4, 41.89),
(15, 1, 5, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `imie` varchar(100) DEFAULT NULL,
  `nazwisko` varchar(100) DEFAULT NULL,
  `login` varchar(100) DEFAULT NULL,
  `haslo` varchar(255) DEFAULT NULL,
  `portfel` float DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `imie`, `nazwisko`, `login`, `haslo`, `portfel`, `type`) VALUES
(1, 'Illia', 'Zaichenko', 'lucky', '1234', 394, 'Admin'),
(2, 'Piotr', 'Stankiewicz', 'popp5', '1234', 0, 'Admin'),
(3, 'Denis', 'Stepien', 'raiczu', '1234', 21156, 'User');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `waluta`
--

CREATE TABLE `waluta` (
  `id` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waluta`
--

INSERT INTO `waluta` (`id`, `name`) VALUES
(1, 'usd'),
(2, 'eur'),
(3, 'uah'),
(4, 'cad'),
(5, 'jpy');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kurs`
--
ALTER TABLE `kurs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `portfel`
--
ALTER TABLE `portfel`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `waluta`
--
ALTER TABLE `waluta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kurs`
--
ALTER TABLE `kurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `portfel`
--
ALTER TABLE `portfel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `waluta`
--
ALTER TABLE `waluta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
