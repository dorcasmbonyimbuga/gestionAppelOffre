-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 juil. 2025 à 23:31
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appel_offre_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `appeloffre`
--

CREATE TABLE `appeloffre` (
  `idAppel` int(11) NOT NULL,
  `refEtatAppel` int(11) NOT NULL,
  `datePub` varchar(20) NOT NULL,
  `objets` varchar(200) NOT NULL,
  `autresInfo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `candidats`
--

CREATE TABLE `candidats` (
  `idCandidat` int(11) NOT NULL,
  `refAppelOffre` int(11) NOT NULL,
  `refFournisseurCandidat` int(11) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `dateCandidature` varchar(20) NOT NULL,
  `autresDetails` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorieproduit`
--

CREATE TABLE `categorieproduit` (
  `idCategorie` int(11) NOT NULL,
  `designationCat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `detailetat`
--

CREATE TABLE `detailetat` (
  `idDetail` int(11) NOT NULL,
  `refEtatDetail` int(11) NOT NULL,
  `refProduit` int(11) NOT NULL,
  `PU` double NOT NULL,
  `Qte` int(11) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `etatbesoin`
--

CREATE TABLE `etatbesoin` (
  `idEtat` int(11) NOT NULL,
  `refFournisseurEtat` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `libelle` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `idFourni` int(11) NOT NULL,
  `noms` varchar(100) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `autres` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pswd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `idPaye` int(11) NOT NULL,
  `refFourniPaye` int(11) NOT NULL,
  `refProduitPaye` int(11) NOT NULL,
  `QtePaye` int(11) NOT NULL,
  `PUPaye` int(11) NOT NULL,
  `datePaye` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `PUProduit` double NOT NULL,
  `unite` varchar(10) NOT NULL,
  `refCategorie` int(11) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pswd` varchar(50) NOT NULL,
  `niveauAcces` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `username`, `pswd`, `niveauAcces`) VALUES
(1, 'Admin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin'),
(2, 'Gabriel', 'e10adc3949ba59abbe56e057f20f883e', 'Admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appeloffre`
--
ALTER TABLE `appeloffre`
  ADD PRIMARY KEY (`idAppel`),
  ADD KEY `fk_etat_appel` (`refEtatAppel`);

--
-- Index pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`idCandidat`),
  ADD KEY `fk_appel_offre` (`refAppelOffre`),
  ADD KEY `fk_fourni_candidat` (`refFournisseurCandidat`);

--
-- Index pour la table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  ADD PRIMARY KEY (`idCategorie`),
  ADD UNIQUE KEY `une_categorie` (`designationCat`);

--
-- Index pour la table `detailetat`
--
ALTER TABLE `detailetat`
  ADD PRIMARY KEY (`idDetail`),
  ADD KEY `fk_etat_detail` (`refEtatDetail`),
  ADD KEY `fk_produit` (`refProduit`);

--
-- Index pour la table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  ADD PRIMARY KEY (`idEtat`),
  ADD KEY `fk_fourni_etat` (`refFournisseurEtat`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`idFourni`),
  ADD UNIQUE KEY `un_fournisseur` (`noms`),
  ADD UNIQUE KEY `un_usename_fournisseur` (`username`),
  ADD UNIQUE KEY `un_contact_forunisseur` (`contact`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`idPaye`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD UNIQUE KEY `un_produit` (`designation`),
  ADD KEY `fk_categorie` (`refCategorie`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `un_usename_user` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appeloffre`
--
ALTER TABLE `appeloffre`
  MODIFY `idAppel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `idCandidat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `detailetat`
--
ALTER TABLE `detailetat`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  MODIFY `idEtat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `idFourni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `payement`
--
ALTER TABLE `payement`
  MODIFY `idPaye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appeloffre`
--
ALTER TABLE `appeloffre`
  ADD CONSTRAINT `fk_etat_appel` FOREIGN KEY (`refEtatAppel`) REFERENCES `etatbesoin` (`idEtat`);

--
-- Contraintes pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD CONSTRAINT `fk_appel_offre` FOREIGN KEY (`refAppelOffre`) REFERENCES `appeloffre` (`idAppel`),
  ADD CONSTRAINT `fk_fourni_candidat` FOREIGN KEY (`refFournisseurCandidat`) REFERENCES `fournisseur` (`idFourni`);

--
-- Contraintes pour la table `detailetat`
--
ALTER TABLE `detailetat`
  ADD CONSTRAINT `fk_etat_detail` FOREIGN KEY (`refEtatDetail`) REFERENCES `etatbesoin` (`idEtat`),
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`refProduit`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  ADD CONSTRAINT `fk_fourni_etat` FOREIGN KEY (`refFournisseurEtat`) REFERENCES `fournisseur` (`idFourni`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`refCategorie`) REFERENCES `categorieproduit` (`idCategorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
