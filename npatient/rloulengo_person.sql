-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 31. Mrz 2022 um 18:07
-- Server-Version: 10.3.31-MariaDB-0+deb10u1
-- PHP-Version: 7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `rloulengo`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rloulengo_person`
--

CREATE TABLE `rloulengo_person` (
  `id_person` int(11) NOT NULL,
  `svnr` varchar(10) DEFAULT NULL COMMENT 'Sozialversicherungsnummer',
  `vorname` varchar(30) DEFAULT NULL,
  `nachname` varchar(30) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `geschlecht` varchar(1) DEFAULT NULL COMMENT 'w m k',
  `gewicht` decimal(5,2) DEFAULT NULL COMMENT 'Gewicht in kg',
  `staatsbuerger` date DEFAULT NULL COMMENT 'Datum ab wann Österr. Staatsbürger',
  `zv` tinyint(1) DEFAULT NULL COMMENT 'Zusatzversicherung 1:ja und 0:nein',
  `essen` int(1) DEFAULT NULL COMMENT 'Zahl von 0 bis 7 als Summe von : 2^0:Abendessen / 2^1:Mittagessen / 2^2:Frühstück'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rloulengo_person`
--

INSERT INTO `rloulengo_person` (`id_person`, `svnr`, `vorname`, `nachname`, `tel`, `email`, `geschlecht`, `gewicht`, `staatsbuerger`, `zv`, `essen`) VALUES
(73, '1234356789', 'Herbert', 'Kaiser', '1234567890', 'hkoenig@tgm.ac.at', 'm', '99.00', '1967-03-03', 0, 7),
(74, '5762121100', 'Rolando', 'Calisthenics', '6767628348', 'rolandocalisthenics@gmail.com', 'w', '12.00', '2015-12-08', 0, 7),
(75, '9878111200', 'Rolando', 'Calisthenics', '6767628348', 'rolandocalisthenics@gmail.com', 'w', '130.00', '2015-12-08', 0, 7);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `rloulengo_person`
--
ALTER TABLE `rloulengo_person`
  ADD PRIMARY KEY (`id_person`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `rloulengo_person`
--
ALTER TABLE `rloulengo_person`
  MODIFY `id_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
