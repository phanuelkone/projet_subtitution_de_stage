-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 05, 2024 at 09:08 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_tech_musee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prénom` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `deck`
--

DROP TABLE IF EXISTS `deck`;
CREATE TABLE IF NOT EXISTS `deck` (
  `id_user` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL DEFAULT 's.jpg',
  `droit` enum('en attente','accepté','refusé') NOT NULL DEFAULT 'en attente',
  `liker` int(11) DEFAULT '0',
  `vue` int(11) DEFAULT '0',
  `visibilite` enum('pub','private') NOT NULL DEFAULT 'private',
  PRIMARY KEY (`id`),
  KEY `fk_deck_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

DROP TABLE IF EXISTS `decks`;
CREATE TABLE IF NOT EXISTS `decks` (
  `deck_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  KEY `decks_id` (`deck_id`),
  KEY `card_id` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_like` (`user_id`,`deck_id`),
  KEY `fk_likes_deck` (`deck_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `deck_id`, `created_at`) VALUES
(1, 6, 4, '2024-07-04 11:48:13'),
(2, 4, 4, '2024-07-04 11:49:17'),
(3, 7, 4, '2024-07-04 11:53:33'),
(4, 7, 5, '2024-07-04 12:03:53'),
(5, 6, 5, '2024-07-04 12:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `partage`
--

DROP TABLE IF EXISTS `partage`;
CREATE TABLE IF NOT EXISTS `partage` (
  `proposeurID` int(11) NOT NULL,
  `receveurID` int(11) NOT NULL,
  `deckproposID` int(11) NOT NULL,
  `deckdemandID` int(11) NOT NULL,
  `Statut` enum('accepte','refuser') NOT NULL DEFAULT 'accepte',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `deck_demand` (`deckdemandID`),
  KEY `DeckProposéID` (`deckproposID`),
  KEY `ReceveurID` (`receveurID`),
  KEY `ProposeurID` (`proposeurID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(100) NOT NULL,
  `description_produit` varchar(300) NOT NULL,
  `picture` varchar(300) CHARACTER SET utf8mb4 NOT NULL,
  `catégorie` varchar(250) NOT NULL,
  `quantité` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `type` enum('Hero','mana','token character','spell','permanent') CHARACTER SET latin1 DEFAULT NULL,
  `fraction` enum('axiom','bravos','lyra','muma','ordis','yzmir') CHARACTER SET latin1 DEFAULT NULL,
  `rarete` enum('unique','commun','rare') NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom_produit`, `description_produit`, `picture`, `catégorie`, `quantité`, `prix`, `type`, `fraction`, `rarete`) VALUES
(61, 'Vegeta', 'hero ', 'Vegeta Blue rage.jpeg', 'sauveur', NULL, 60, 'Hero', 'axiom', 'rare'),
(62, 'San Goku', 'Héro miraculeux', 's-l1600.png', 'Hero', NULL, 70, 'mana', 'axiom', 'rare'),
(63, 'Cell', 'antagoniste', 'Dcdv3wq-d81c3fe6-bb81-499b-84ea-2278ddeda13a.webp', 'Mana', NULL, 50, 'token character', 'muma', 'commun'),
(64, 'Whis', 'ange soigneur', 'w.jpg', 'soigneur', NULL, 45, 'token character', 'lyra', 'commun'),
(65, 'Trunks', 'l\'homme de la derniere minute', 'figurine-dbz-trunks-adulte-super-saiyan.png', 'Permanent', NULL, 30, 'token character', 'lyra', 'commun'),
(66, 'jiren', 'spell', 'j.jpg', '', NULL, 20, 'spell', 'lyra', 'unique'),
(67, 'buu', 'spell', 'bb.jpg', '', NULL, 45, 'spell', 'lyra', 'commun'),
(68, 'Broly', 'token character', 'bro.jpg', '', NULL, 70, 'token character', 'ordis', 'unique'),
(69, 'Beerus', 'PERMANENT', 'i.jpg', '', NULL, 100, 'permanent', 'bravos', 'rare'),
(70, 'Krilin', 'Hero', 'images.jpeg', '', NULL, 70, 'Hero', 'yzmir', 'unique'),
(71, 'piccolo', 'token character', 'Piccolomanga.webp', '', NULL, 90, 'token character', 'bravos', 'unique'),
(72, 'San Gohan', 'hero', 'FinalBeastGohan.webp', '', NULL, 85, 'Hero', 'ordis', 'rare');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(100) NOT NULL DEFAULT 'Buste de david.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `image`) VALUES
(4, 'a', 'a@gmail.com', '$2y$10$5w4yfdR2D5dgoGsxMd7N4eDgJQvmni2eKnzD3qjeoKi.8yT.nGUUu', '2024-04-18 13:02:22', '2024-04-18 13:02:22', ''),
(6, 'jarius@gmail.comm', 'jarius@gmail.comm', '$2y$10$V7c8Cd0lxFYDNhEwixCLLe3rA6WPbhvFWU4.bJjXPfss/oB6dONqW', '2024-06-19 12:07:00', '2024-06-19 12:07:00', ''),
(7, 'batard', 'b@gmail.com', '$2y$10$ZolFcQ1biLP3Yae9ZP/./uSqvQ4tJV2GK3tNBI.MpSFj8P7p9tnT.', '2024-07-04 11:53:12', '2024-07-04 11:53:12', 'Buste de david.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expiry_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `token`, `expiry_time`) VALUES
(1, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxMzczODM1OX0.SnlxxR82NiPS_lFydswkbdqz13SsOHDcECXSQfD_J4Q', '2024-04-21 22:25:59'),
(2, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxMzczODY4MX0.VXuAE5o9zwdlkDssSPZDx51FhB2EEuMwoBwJjgwnxb4', '2024-04-21 22:31:21'),
(3, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxNjU1ODAwMH0.S8SCpI1QKmj6sX6QEfg3O2kzDSI-CwGmlsvLNFKt4ns', '2024-05-24 13:40:00'),
(4, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxNzA5MzUxMH0.OrJfatCjYDxkbJHsKw9pCvWW_Dg_tf264AofkkvqHP4', '2024-05-30 18:25:10'),
(5, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxNzA5NzExMn0.MGHpdGgQZT57GlsB0Pg3mgFVdnK2bx0kU_7Ayd2K2s8', '2024-05-30 19:25:12'),
(6, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxNzA5NzIyMn0.NyznneuIFRGwxPsSYV-5-LhPpcwuWHyEr8Tj7KsW1ss', '2024-05-30 19:27:02'),
(7, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcxNzIwNDA2OX0.qCsBXnNyAjNGNZjf8riMDStysamfwT_KTe0XAgSO4IQ', '2024-06-01 01:07:49'),
(8, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxODgwNjA0Nn0.ygzsQdLQZFshdWsawJQOFDD19xmgnWZAjQ8COxnavb4', '2024-06-19 14:07:26'),
(9, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxODgwODc5NH0.VOqgXmyzGMqh8vL4LHUCKd6MQz6dIHjfTvKf9otoGK8', '2024-06-19 14:53:14'),
(10, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxODgwOTU0NH0.QRMwBLlLPTT7Zn-so9SjiYTOBuY4bS0i5-fIsEepeW4', '2024-06-19 15:05:44'),
(11, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxOTI2MDAyMH0.H7r7n4uzefuqEungbpBT0rVx8aIcQS1u9pgczvSH304', '2024-06-24 20:13:40'),
(12, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxOTI2NDkzM30.No8NXbDZvX-t7nE5ccizGhf4IUYjVGpOuaQ-tOY-gLo', '2024-06-24 21:35:33'),
(13, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcxOTI2ODE5Mn0.K6euxMT1EXeBh0JmmVWH0nOHvE4O3Qwshp3WCGxgL04', '2024-06-24 22:29:52'),
(14, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDA5ODg1M30.4Dkt_Sl1XAM7URl9XQwKGRGuUkcjBaPHM5dzWxj0QDg', '2024-07-04 13:14:13'),
(15, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcyMDA5OTkwN30.lfR5KnbMobdnOQAS-NY2f2lvYyPHVQHOIGnoxpj-I74', '2024-07-04 13:31:47'),
(16, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDA5OTk4OH0.Zl1uW-vN8a85Xj4S610pUuVR43DgmL-OMC6UQWq9O8s', '2024-07-04 13:33:08'),
(17, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcyMDEwMDAyNX0.Js3DPPM3i2GwoigbZIIsWQRFCz-QckcJ8G-0Otwf0XA', '2024-07-04 13:33:45'),
(18, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcyMDEwMDE0NH0.mOZ4JIVApzDiC_BSRnIwG_nnrQdsWyEbj1ftb-dQHkU', '2024-07-04 13:35:44'),
(19, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDEwMDI1NX0.hFRNnS3cmfLyGO8zWxdCdMi9GgttSWjcIoIAIxHsqwc', '2024-07-04 13:37:35'),
(20, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDEwMDUyOX0.AzV3p2XmD4hZNk1D07lxGsUNGXbsowUppTY3ZLsLpBk', '2024-07-04 13:42:09'),
(21, 4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNCIsImV4cCI6MTcyMDEwMDk1Mn0.WLNbR3-WwC0ibN2PATkW3PJ2T341rfyjbUCeSog7wk4', '2024-07-04 13:49:12'),
(22, 7, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNyIsImV4cCI6MTcyMDEwMTIwMn0.IUvzFjB5MEUMhU8RhUPp7haBL8cmU7PCIk8mRmKX2b4', '2024-07-04 13:53:22'),
(23, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDEwMTU3M30.-QhsLHrROontFizPDp0bEsiU5WEMMyMwS3SIe_f33k8', '2024-07-04 13:59:33'),
(24, 7, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNyIsImV4cCI6MTcyMDEwMTc2OH0.UDfB30q8DKtW4Z9iZcneqXBEDXMlKW6BfngGFBAGCOc', '2024-07-04 14:02:48'),
(25, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDEwMjkxNH0.R7v5WTqPXNqLRXLV6LtbHo7pDXGjUNk1M7ze6MoKo4M', '2024-07-04 14:21:54'),
(26, 6, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNiIsImV4cCI6MTcyMDE3NzI2NH0.vYMZU9iVqoywiETg2oViGuudFiEpqSGKUcS6vsDgSFE', '2024-07-05 11:01:04');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `decks`
--
ALTER TABLE `decks`
  ADD CONSTRAINT `card_id` FOREIGN KEY (`card_id`) REFERENCES `produit` (`id_produit`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_deck` FOREIGN KEY (`deck_id`) REFERENCES `deck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partage`
--
ALTER TABLE `partage`
  ADD CONSTRAINT `DeckProposéID` FOREIGN KEY (`deckproposID`) REFERENCES `deck` (`id`),
  ADD CONSTRAINT `ProposeurID` FOREIGN KEY (`proposeurID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ReceveurID` FOREIGN KEY (`receveurID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `deck_demand` FOREIGN KEY (`deckdemandID`) REFERENCES `deck` (`id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_jfk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
