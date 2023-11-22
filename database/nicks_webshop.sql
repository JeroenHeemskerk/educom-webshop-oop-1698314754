-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 nov 2023 om 12:59
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nicks_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`) VALUES
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(86, 1),
(88, 1),
(53, 16),
(54, 18),
(84, 30),
(85, 31),
(87, 32);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_row`
--

CREATE TABLE `order_row` (
  `row_id` int(20) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `amount` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order_row`
--

INSERT INTO `order_row` (`row_id`, `order_id`, `product_id`, `amount`) VALUES
(21, 39, 1, 203),
(22, 40, 2, 20),
(23, 41, 3, 2),
(24, 42, 1, 10),
(25, 42, 2, 10),
(26, 43, 1, 10),
(27, 43, 3, 100),
(28, 44, 1, 5),
(29, 45, 1, 50),
(30, 46, 2, 1),
(31, 46, 1, 1),
(32, 46, 3, 7),
(33, 52, 2, 5),
(34, 52, 5, 50),
(35, 53, 3, 10),
(36, 54, 2, 3),
(37, 55, 1, 9),
(38, 55, 3, 3),
(39, 76, 1, 1),
(40, 76, 2, 1),
(41, 76, 5, 1),
(42, 77, 2, 20),
(43, 77, 4, 20),
(44, 79, 3, 1),
(45, 79, 4, 50),
(46, 80, 1, 1),
(47, 80, 2, 1),
(48, 80, 3, 1),
(49, 81, 2, 3),
(50, 81, 5, 1),
(51, 82, 1, 1),
(52, 82, 3, 1),
(53, 83, 1, 2),
(54, 83, 2, 2),
(55, 83, 3, 1),
(56, 83, 4, 1),
(57, 83, 5, 1),
(58, 84, 1, 1),
(59, 85, 2, 1),
(60, 86, 1, 1),
(61, 86, 2, 1),
(62, 86, 3, 1),
(63, 87, 3, 2),
(64, 87, 5, 5),
(65, 88, 1, 1),
(66, 88, 2, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_picture_location` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `product_picture_location`) VALUES
(1, 'Schoenen', 'Sportschoenen van een bekend merk.', 69.99, 'Sportschoenen.png'),
(2, 'Strandstoel', 'Een stoel voor op het strand.', 30.00, 'strandstoel.png'),
(3, 'Kat', 'Een nieuwsgierige kitten.', 129.50, 'kat.png'),
(4, 'Boot', 'Deze boot gaat zo hard als u kan roeien.', 300.00, 'boot.png'),
(5, 'Auto', 'Deze auto werd heel lang geleden gebruikt waardoor de motor stuk is.', 2500.00, 'auto.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ratings`
--

CREATE TABLE `ratings` (
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ratings`
--

INSERT INTO `ratings` (`product_id`, `user_id`, `rating`) VALUES
(1, 1, '4');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email_address` varchar(80) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `name`, `email_address`, `password`) VALUES
(1, 'Nick Koole', 'nickkoole@hotmail.com', 'nick'),
(16, 's', 's@s.s', 's'),
(17, 'a', 'a@a.a', 'a'),
(18, 'b', 'b@b.b', 'b'),
(19, 'b', 'c@c.c', 'c'),
(20, 'Kees', 'Kees@kees.kees', 'p'),
(21, 'Piet', 'piet@t.t', 'p'),
(22, 'Sjaak', 'sjakie@sjakie.sjakie', 's'),
(26, 'Joost', 'Joost@t.t', 's'),
(27, 'Joost', 'Joost@t.t', 's'),
(28, 'Joost', 'Joost@t.t', 's'),
(29, 'Jaap', 'jaap@t.t', 's'),
(30, 'pp', 'pp@pp.pp', 'pp'),
(31, 'nnn', 'nn@nnn.n', 'n'),
(32, 'g', 'g@g.g', 'g'),
(33, 'jj', 'jj@jj.jj', 'j');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `order_row`
--
ALTER TABLE `order_row`
  ADD PRIMARY KEY (`row_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT voor een tabel `order_row`
--
ALTER TABLE `order_row`
  MODIFY `row_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Beperkingen voor tabel `order_row`
--
ALTER TABLE `order_row`
  ADD CONSTRAINT `order_row_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `order_row_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Beperkingen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
