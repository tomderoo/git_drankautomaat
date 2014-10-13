-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 25 aug 2014 om 10:02
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `drankautomaat`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `drank`
--

CREATE TABLE IF NOT EXISTS `drank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(20) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden geëxporteerd voor tabel `drank`
--

INSERT INTO `drank` (`id`, `name`, `price`, `image`, `number`) VALUES
(1, 'Coca-Cola', 80, 'cocacola.png', 5),
(2, 'Sprite', 110, 'sprite.png', 10),
(3, 'Ice-Tea', 140, 'liptonicetea.png', 4),
(4, 'Oasis', 130, 'oasis.png', 5),
(5, 'Aquarius', 180, 'aquarius.png', 3),
(6, 'Seven-Up', 110, 'sevenup.png', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `geldlade`
--

CREATE TABLE IF NOT EXISTS `geldlade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waarde` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden geëxporteerd voor tabel `geldlade`
--

INSERT INTO `geldlade` (`id`, `waarde`, `aantal`) VALUES
(1, 10, 49),
(2, 20, 51),
(3, 50, 52),
(4, 100, 52),
(5, 200, 49);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
