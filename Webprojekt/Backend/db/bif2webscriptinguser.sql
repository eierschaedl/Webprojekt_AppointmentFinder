-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Apr 2022 um 11:22
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
-- Tabellenstruktur für Tabelle `appointments`
--

CREATE TABLE `appointments` (
                                `appointment_id` int(11) NOT NULL,
                                `name` varchar(255) NOT NULL,
                                `description` varchar(1000) NOT NULL,
                                `creator` varchar(255) NOT NULL,
                                `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `name`, `description`, `creator`, `active`) VALUES
                                                                                              (5, 'Test Event 1', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing', 'Jassi', 1),
                                                                                              (6, 'Test Event 2', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum daccusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing', 'Jassi', 1),
                                                                                              (7, 'inaktives Event', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing', 'Gerald', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dateoptions`
--

CREATE TABLE `dateoptions` (
                               `dateOptions_id` int(11) NOT NULL,
                               `start` datetime NOT NULL,
                               `end` datetime NOT NULL,
                               `votes` int(11) NOT NULL,
                               `fk_appointment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `dateoptions`
--

INSERT INTO `dateoptions` (`dateOptions_id`, `start`, `end`, `votes`, `fk_appointment_id`) VALUES
                                                                                               (1, '2022-04-29 15:50:00', '2022-04-29 16:00:00', 0, 5),
                                                                                               (2, '2022-04-30 08:00:00', '2022-04-30 09:00:00', 2, 6),
                                                                                               (3, '2022-05-01 08:00:00', '2022-05-01 09:00:00', 1, 6),
                                                                                               (4, '2022-04-22 08:00:00', '2022-04-22 12:00:00', 0, 7),
                                                                                               (5, '2022-04-25 08:00:00', '2022-04-25 12:00:00', 0, 7),
                                                                                               (6, '2022-04-26 08:00:00', '2022-04-26 12:00:00', 0, 7),
                                                                                               (7, '2022-04-27 08:00:00', '2022-04-27 12:00:00', 0, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `people`
--

CREATE TABLE `people` (
                          `person_id` int(11) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `people`
--

INSERT INTO `people` (`person_id`, `name`, `comment`) VALUES
                                                          (1, 'Jassi', 'Hallo. Hab abgestimmt.'),
                                                          (2, 'Gerald', 'Heeeeello. Ich kann nur am Freitag.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `people_dateoptions`
--

CREATE TABLE `people_dateoptions` (
                                      `person_id` int(11) NOT NULL,
                                      `dateOption_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `people_dateoptions`
--

INSERT INTO `people_dateoptions` (`person_id`, `dateOption_id`) VALUES
                                                                    (1, 2),
                                                                    (1, 3),
                                                                    (2, 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `appointments`
--
ALTER TABLE `appointments`
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
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `appointments`
--
ALTER TABLE `appointments`
    MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `dateoptions`
--
ALTER TABLE `dateoptions`
    MODIFY `dateOptions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `people`
--
ALTER TABLE `people`
    MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `dateoptions`
--
ALTER TABLE `dateoptions`
    ADD CONSTRAINT `fk_dateOptions_appointments` FOREIGN KEY (`fk_appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
