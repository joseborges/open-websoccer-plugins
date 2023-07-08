-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Mai 2017 um 16:40
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `soccer`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `_anpassungen`
--

CREATE TABLE `_anpassungen` (
  `id` int(10) NOT NULL,
  `spieler_id` int(10) NOT NULL,
  `position_main` enum('T','LV','IV','RV','LM','DM','ZM','OM','RM','LS','MS','RS') DEFAULT NULL,
  `position_second` enum('T','LV','IV','RV','LM','DM','ZM','OM','RM','LS','MS','RS') DEFAULT NULL,
  `marktwert_neu` int(10) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `admin_approval_pending` enum('1','0') NOT NULL DEFAULT '1',
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `_anpassungen`
--
ALTER TABLE `_anpassungen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ws3_toffer_spieler_id_fk` (`spieler_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `_anpassungen`
--
ALTER TABLE `_anpassungen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=643;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
