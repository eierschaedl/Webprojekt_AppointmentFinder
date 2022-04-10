-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Apr 2022 um 18:39
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bif2webscriptinguser`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `appoinments`
--

CREATE TABLE `appoinments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateoptions`
--

CREATE TABLE `dateoptions` (
  `dateOptions_id` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `votes` int(11) NOT NULL,
  `fk_appointment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `people`
--

CREATE TABLE `people` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `people_dateoptions`
--

CREATE TABLE `people_dateoptions` (
  `person_id` int(11) NOT NULL,
  `dateOption_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `appoinments`
--
ALTER TABLE `appoinments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indizes für die Tabelle `dateoptions`
--
ALTER TABLE `dateoptions`
  ADD PRIMARY KEY (`dateOptions_id`),
  ADD KEY `fk_dateOptions_appointments` (`fk_appointment_id`);

--
-- Indizes für die Tabelle `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`person_id`);

--
-- Indizes für die Tabelle `people_dateoptions`
--
ALTER TABLE `people_dateoptions`
  ADD PRIMARY KEY (`person_id`,`dateOption_id`),
  ADD KEY `fk_dateOptions` (`dateOption_id`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `dateoptions`
--
ALTER TABLE `dateoptions`
  ADD CONSTRAINT `fk_dateOptions_appointments` FOREIGN KEY (`fk_appointment_id`) REFERENCES `appoinments` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `people_dateoptions`
--
ALTER TABLE `people_dateoptions`
  ADD CONSTRAINT `fk_dateOptions` FOREIGN KEY (`dateOption_id`) REFERENCES `dateoptions` (`dateOptions_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_people` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
