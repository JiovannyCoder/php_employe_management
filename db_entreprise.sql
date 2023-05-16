-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 31 Mars 2017 à 11:46
-- Version du serveur :  5.5.54-0+deb8u1
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db_entreprise`
--
CREATE DATABASE IF NOT EXISTS `db_entreprise` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_entreprise`;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE IF NOT EXISTS `employe` (
`id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `date_arrivee` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`id`, `nom`, `prenom`, `date_naissance`, `date_arrivee`) VALUES
(1, 'CENITZ', 'Pantxika', '1988-06-22', '2010-02-01'),
(2, 'ILBARRITZ', 'Iban', '1970-01-01', '1990-05-14'),
(3, 'UHABIA', 'Peio', '1982-07-26', '2005-02-07'),
(4, 'ERRETEGIA', 'Bixente', '1983-11-08', '2005-05-02'),
(5, 'MILADY', 'Xabi', '1975-04-08', '1994-09-07'),
(6, 'PARLEMENTIA', 'Patxi', '1985-08-25', '2008-09-08'),
(7, 'ACOTZ', 'Maylis', '1980-03-16', '2010-01-11'),
(8, 'JAIZKIBEL', 'Maider', '1987-12-05', '2011-04-04'),
(9, 'CHIBERTA', 'Silban', '1985-08-11', '2008-01-21'),
(10, 'IPPARLA', 'Arantxa', '1978-06-02', '2008-01-07'),
(11, 'MARBELLA', 'Aitor', '1981-01-21', '2008-01-07'),
(12, 'URSUYA', 'Amaya', '1987-06-20', '2009-01-23'),
(13, 'IZPEGUI', 'Aniela', '1965-10-19', '1995-04-03'),
(14, 'IBARDINE', 'Elorri', '1959-08-02', '1998-09-14'),
(15, 'DANTXARIA', 'Gorka', '1955-10-04', '1994-11-28'),
(16, 'BIDARRAY', 'Jon', '1973-12-09', '1995-01-23'),
(17, 'HOLZARTE', 'Maialen', '1976-02-29', '2003-06-09'),
(18, 'IROULEGUY', 'Maika', '1984-02-04', '2007-01-29'),
(19, 'URCURAY', 'Mayana', '1972-06-10', '1999-01-11'),
(20, 'JAIZKIBEL', 'Unai', '1963-10-01', '1997-01-13'),
(21, 'URSUYA', 'Xilban', '1966-11-21', '1995-01-09'),
(22, 'BEHERETA', 'Haritza', '1985-01-25', '2002-12-03');

-- --------------------------------------------------------

--
-- Structure de la table `exerce`
--

CREATE TABLE IF NOT EXISTS `exerce` (
  `id_employe` int(11) NOT NULL,
  `id_metier` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `temps` enum('plein','mi-temps','quart-temps') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `exerce`
--

INSERT INTO `exerce` (`id_employe`, `id_metier`, `id_service`, `temps`) VALUES
(1, 6, 4, 'mi-temps'),
(1, 7, 5, 'mi-temps'),
(2, 15, 2, 'plein'),
(3, 8, 3, 'mi-temps'),
(3, 8, 7, 'mi-temps'),
(4, 5, 9, 'plein'),
(5, 1, 5, 'plein'),
(6, 8, 3, 'mi-temps'),
(6, 13, 7, 'mi-temps'),
(7, 11, 4, 'mi-temps'),
(7, 11, 5, 'mi-temps'),
(8, 17, 3, 'mi-temps'),
(8, 17, 7, 'mi-temps'),
(9, 17, 3, 'quart-temps'),
(9, 17, 6, 'mi-temps'),
(9, 17, 7, 'quart-temps'),
(10, 10, 4, 'plein'),
(11, 13, 3, 'plein'),
(11, 13, 7, 'plein'),
(12, 12, 1, 'plein'),
(13, 2, 2, 'plein'),
(14, 16, 5, 'mi-temps'),
(14, 16, 8, 'mi-temps'),
(15, 1, 7, 'plein'),
(16, 1, 8, 'plein'),
(17, 7, 4, 'plein'),
(18, 16, 1, 'mi-temps'),
(18, 16, 4, 'mi-temps'),
(19, 3, 6, 'mi-temps'),
(19, 9, 6, 'mi-temps'),
(20, 14, 1, 'plein'),
(21, 4, 6, 'plein'),
(22, 8, 7, 'plein');

-- --------------------------------------------------------

--
-- Structure de la table `metier`
--

CREATE TABLE IF NOT EXISTS `metier` (
`id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `metier`
--

INSERT INTO `metier` (`id`, `nom`) VALUES
(1, 'Directeur de service'),
(2, 'Secretaire de direction'),
(3, 'Administrateur systeme'),
(4, 'Directeur du systeme d''information'),
(5, 'Magasinier'),
(6, 'Commercial'),
(7, 'Vendeur'),
(8, 'Mecanicien'),
(9, 'Administrateur reseau'),
(10, 'Relation client'),
(11, 'Manager'),
(12, 'Comptable'),
(13, 'Automaticien'),
(14, 'Expert comptable'),
(15, 'President directeur general'),
(16, 'Secretaire'),
(17, 'Informaticien');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
`id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`id`, `nom`) VALUES
(1, 'Comptabilite'),
(2, 'Direction'),
(3, 'Maintenance'),
(4, 'Commercial'),
(5, 'Export'),
(6, 'Informatique'),
(7, 'Production'),
(8, 'Achat'),
(9, 'Entrepot');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exerce`
--
ALTER TABLE `exerce`
 ADD PRIMARY KEY (`id_employe`,`id_metier`,`id_service`), ADD KEY `id_employe` (`id_employe`), ADD KEY `id_metier` (`id_metier`), ADD KEY `id_service` (`id_service`);

--
-- Index pour la table `metier`
--
ALTER TABLE `metier`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `metier`
--
ALTER TABLE `metier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `exerce`
--
ALTER TABLE `exerce`
ADD CONSTRAINT `exerce_ibfk_1` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `exerce_ibfk_2` FOREIGN KEY (`id_metier`) REFERENCES `metier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `exerce_ibfk_3` FOREIGN KEY (`id_service`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
