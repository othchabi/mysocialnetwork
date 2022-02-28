-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 avr. 2021 à 08:58
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `network`
--

-- --------------------------------------------------------

--
-- Structure de la table `ami`
--

CREATE TABLE `ami` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_ami1` int(10) UNSIGNED NOT NULL,
  `id_ami2` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `id_post` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `id` int(11) UNSIGNED NOT NULL,
  `lesamis` varchar(25) NOT NULL DEFAULT 'amis',
  `labio` varchar(25) NOT NULL DEFAULT 'amis',
  `lespublications` varchar(25) NOT NULL DEFAULT 'amis',
  `id_user` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) UNSIGNED NOT NULL,
  `body` varchar(244) NOT NULL,
  `Date` datetime NOT NULL,
  `id_profile` int(11) UNSIGNED NOT NULL,
  `likes` int(11) UNSIGNED NOT NULL,
  `post_photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `post_fil`
--

CREATE TABLE `post_fil` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_filuser` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `post_like`
--

CREATE TABLE `post_like` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_post` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `requete_ami`
--

CREATE TABLE `requete_ami` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_recoit` int(11) UNSIGNED NOT NULL,
  `id_envoie` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `token_connexion`
--

CREATE TABLE `token_connexion` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `id_utilisateur` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `token_mdp`
--

CREATE TABLE `token_mdp` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `id_utilisateur` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(10) UNSIGNED NOT NULL,
  `pseudo` varchar(32) COLLATE armscii8_bin NOT NULL,
  `mdp` varchar(60) COLLATE armscii8_bin NOT NULL,
  `email` varchar(60) COLLATE armscii8_bin NOT NULL,
  `photo_profil` varchar(50) COLLATE armscii8_bin NOT NULL DEFAULT 'image/defaut.png',
  `bio` varchar(500) COLLATE armscii8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ami`
--
ALTER TABLE `ami`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ami1` (`id_ami1`),
  ADD KEY `id_ami2` (`id_ami2`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_profile` (`id_profile`);

--
-- Index pour la table `post_fil`
--
ALTER TABLE `post_fil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_fil_ibfk_1` (`id_filuser`);

--
-- Index pour la table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `requete_ami`
--
ALTER TABLE `requete_ami`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_envoie` (`id_envoie`),
  ADD KEY `id_recoit` (`id_recoit`);

--
-- Index pour la table `token_connexion`
--
ALTER TABLE `token_connexion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `token_mdp`
--
ALTER TABLE `token_mdp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ami`
--
ALTER TABLE `ami`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT pour la table `post_fil`
--
ALTER TABLE `post_fil`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=418;

--
-- AUTO_INCREMENT pour la table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT pour la table `requete_ami`
--
ALTER TABLE `requete_ami`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `token_connexion`
--
ALTER TABLE `token_connexion`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT pour la table `token_mdp`
--
ALTER TABLE `token_mdp`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ami`
--
ALTER TABLE `ami`
  ADD CONSTRAINT `ami_ibfk_1` FOREIGN KEY (`id_ami1`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `ami_ibfk_2` FOREIGN KEY (`id_ami2`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `informations`
--
ALTER TABLE `informations`
  ADD CONSTRAINT `informations_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `post_fil`
--
ALTER TABLE `post_fil`
  ADD CONSTRAINT `post_fil_ibfk_1` FOREIGN KEY (`id_filuser`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `requete_ami`
--
ALTER TABLE `requete_ami`
  ADD CONSTRAINT `requete_ami_ibfk_1` FOREIGN KEY (`id_envoie`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `requete_ami_ibfk_2` FOREIGN KEY (`id_recoit`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `token_connexion`
--
ALTER TABLE `token_connexion`
  ADD CONSTRAINT `token_connexion_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
