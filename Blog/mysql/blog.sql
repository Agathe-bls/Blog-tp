-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 nov. 2026 à 17:23
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

CREATE DATABASE IF NOT EXISTS blog DEFAULT CHARACTER SET utf8mb4;
USE blog;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL COMMENT 'Contenu du commentaire',
  `pseudo` varchar(50) NOT NULL,
  `article_id` int NOT NULL COMMENT 'Identifiant de l''article commenté',
  PRIMARY KEY (`id`),
  KEY `fk_commentaire_article` (`article_id`),
  KEY `fk_commentaire_user` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL COMMENT 'Contenu de l''article',
  `pseudo` varchar(50) NOT NULL,
  `categorie_id` int DEFAULT NULL COMMENT 'Identifiant de la catégorie',
  PRIMARY KEY (`id`),
  KEY `fk_article_categorie` (`categorie_id`),
  KEY `fk_article_user` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`pseudo`) REFERENCES `user` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaire_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_commentaire_user` FOREIGN KEY (`pseudo`) REFERENCES `user` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

-- Ajout lignes Admin
INSERT INTO `user`(`email`, `mdp`, `pseudo`, `admin`)
VALUES ('admin@localhost.fr','admin69IUT','Administrateur','1');

-- Ajout Catégorie

INSERT INTO `categorie`(`nom`)
VALUES ('Infos');

INSERT INTO `categorie`(`nom`)
VALUES ('Informatique');

INSERT INTO `categorie`(`nom`)
VALUES ('Sport');

INSERT INTO `categorie`(`nom`)
VALUES ('Culture');


-- Ajout Article de bienvenu
INSERT INTO `article`(`titre`, `description`, `categorie_id`, `pseudo`)
VALUES (
    'Bienvenue sur The Blog !',
    'Bonjour et bienvenue sur The Blog !

Cet espace est le vôtre : un endroit simple pour partager vos idées, raconter vos expériences et échanger avec les autres membres de la communauté.

Pour publier, rien de plus facile : connectez-vous, cliquez sur « Poster » dans le menu, puis renseignez un titre, une description et une catégorie. Votre article apparaîtra aussitôt sur la page d''accueil.

N''oubliez pas de vous déconnecter !

Quelques conseils pour bien démarrer :
- Choisissez un titre clair qui résume votre propos.
- Sélectionnez la catégorie qui correspond le mieux à votre sujet.
- Relisez-vous avant de publier : un article soigné se lit mieux.

Bonne lecture et bonne écriture !',
    '1',
    'Administrateur'
);

-- Ajout commentaire sur l'article de l'administrateur
INSERT INTO `commentaire`(`description`, `pseudo`, `article_id`)
VALUES (
  'Vous pouvez également réagir aux posts des autres en laissant un commentaire, et supprimer à tout moment vos propres articles ou commentaires !',
  'Administrateur',
  '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
