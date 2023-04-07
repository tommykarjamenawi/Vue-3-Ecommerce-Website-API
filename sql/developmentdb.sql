-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 22 jan 2023 om 20:35
-- Serverversie: 10.10.2-MariaDB-1:10.10.2+maria~ubu2204
-- PHP-versie: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
CREATE DATABASE IF NOT EXISTS developmentdb;

--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ORDERS`
--

CREATE TABLE `ORDERS` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ORDERS`
--

INSERT INTO `ORDERS` (`id`, `user_id`) VALUES
(3, 1),
(4, 1),
(1, 8),
(2, 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ORDER_ITEMS`
--

CREATE TABLE `ORDER_ITEMS` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ORDER_ITEMS`
--

INSERT INTO `ORDER_ITEMS` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 2, 3),
(2, 1, 3, 1),
(3, 1, 1, 1),
(4, 2, 3, 4),
(5, 2, 2, 4),
(6, 2, 1, 1),
(7, 3, 10, 12),
(8, 3, 2, 3),
(9, 3, 1, 1),
(10, 3, 6, 4),
(11, 3, 7, 2),
(12, 4, 1, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `PRODUCTS`
--

CREATE TABLE `PRODUCTS` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `image` varchar(5000) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `price` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `PRODUCTS`
--

INSERT INTO `PRODUCTS` (`id`, `name`, `description`, `image`, `category`, `brand`, `price`) VALUES
(1, 'Nike Shoes', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/image 5.png', 'casual', 'nike', '199.90'),
(2, 'Sneaker Skate Shoes', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/Daco_1703273 1.png', 'casual', 'nike', '599.00'),
(3, 'Sneaker Basketball Shoes', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/pngegg 1.png', 'casual', 'nike', '705.00'),
(6, 'Prestige High-Cut Leather', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/Mask Group.png', 'formal', 'High', '621.00'),
(7, 'Slip-On Formal Shoes', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/Rectangle 38.png', 'formal', 'High', '461.00'),
(10, 'Slip-Off Formal Shoes', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi, quis?', '/img/shop/Rectangle 39.png', 'formal', 'High', '699.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `USERS`
--

INSERT INTO `USERS` (`id`, `full_name`, `email`, `password`, `address`, `role`, `image`) VALUES
(1, 'tommy karja', 'tk@shop.nl', '$2y$10$SJGxkdiNknRpQppRiVoZa.dLKk5PKYGgxpTwcS7mi3VhebzYgrQIC', 'Haarlem1', 1, '/img/defaultprofile.jpg'),
(8, 'test tester', 'test@shop.nl', '$2y$10$fB8Q11HbCqOMN.DFShiv2uWMPkAx81ECqZunkaOLJ/LT3QN1RcmxC', 'Haarlem1', 2, '/img/defaultprofile.jpg'),
(10, 'edit me', 'edit@shop.nl', '$2y$10$7qQWGYenoxg3gDpFLIKvrOQHAebG.DcqTIF5L4.4qhS1jDvDGgeR6', 'Haarlem1', 2, '/img/defaultprofile.jpg');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `ORDER_ITEMS`
--
ALTER TABLE `ORDER_ITEMS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `PRODUCTS`
--
ALTER TABLE `PRODUCTS`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `ORDERS`
--
ALTER TABLE `ORDERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `ORDER_ITEMS`
--
ALTER TABLE `ORDER_ITEMS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `PRODUCTS`
--
ALTER TABLE `PRODUCTS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD CONSTRAINT `ORDERS_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `USERS` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `ORDER_ITEMS`
--
ALTER TABLE `ORDER_ITEMS`
  ADD CONSTRAINT `ORDER_ITEMS_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ORDERS` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ORDER_ITEMS_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `PRODUCTS` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
