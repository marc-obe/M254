-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Jun 2022 um 18:58
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projektarbeit`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_benutzer`
--

CREATE TABLE `tbl_benutzer` (
  `id` int(11) NOT NULL,
  `vorname` varchar(20) NOT NULL,
  `nachname` varchar(20) NOT NULL,
  `eMail` varchar(50) NOT NULL,
  `benutzername` varchar(50) NOT NULL,
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_witze`
--

CREATE TABLE `tbl_witze` (
  `id` int(11) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `inhalt` text NOT NULL,
  `benutzerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_benutzer`
--
ALTER TABLE `tbl_benutzer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tbl_witze`
--
ALTER TABLE `tbl_witze`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benutzerId` (`benutzerId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_benutzer`
--
ALTER TABLE `tbl_benutzer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_witze`
--
ALTER TABLE `tbl_witze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_witze`
--
ALTER TABLE `tbl_witze`
  ADD CONSTRAINT `tbl_witze_ibfk_1` FOREIGN KEY (`benutzerId`) REFERENCES `tbl_benutzer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
