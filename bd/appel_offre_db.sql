-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 27 juin 2025 à 05:24
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

--
-- Déchargement des données de la table `appeloffre`
--

INSERT INTO `appeloffre` (`idAppel`, `refEtatAppel`, `datePub`, `objets`, `autresInfo`) VALUES
(1, 1, '2025-06-10', 'Requisition biscuits', 'Aucun'),
(3, 1, '2025-06-25', 'Requisition Jus', 'Jus'),
(4, 4, '2025-06-26', 'Requisition Jus Afia', 'Aucune');

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

--
-- Déchargement des données de la table `candidats`
--

INSERT INTO `candidats` (`idCandidat`, `refAppelOffre`, `refFournisseurCandidat`, `statut`, `dateCandidature`, `autresDetails`) VALUES
(1, 1, 1, 'Publier', '2025-06-10', 'Rapidite uihoroe ytreertyu'),
(6, 1, 3, 'Envoyer', '2025-06-24', 'ertyuio'),
(7, 1, 2, 'Publier', '2025-06-01', 'oiuytr'),
(8, 3, 2, 'en attente', '2025-06-26', 'Rapidite et fiabilite'),
(9, 3, 7, 'en attente', '2025-06-26', 'Meilleur offre'),
(10, 1, 7, 'en attente', '2025-06-26', 'Prioritaire'),
(11, 4, 7, 'Reçu', '2025-06-26', 'Prix promotionnelle');

-- --------------------------------------------------------

--
-- Structure de la table `categorieproduit`
--

CREATE TABLE `categorieproduit` (
  `idCategorie` int(11) NOT NULL,
  `designationCat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorieproduit`
--

INSERT INTO `categorieproduit` (`idCategorie`, `designationCat`) VALUES
(1, 'Biscuit'),
(2, 'Jus'),
(3, 'Bonbons'),
(5, 'Jus'),
(6, 'Jus');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `detailetat`
--

INSERT INTO `detailetat` (`idDetail`, `refEtatDetail`, `refProduit`, `PU`, `Qte`) VALUES
(1, 1, 1, 200, 50),
(2, 3, 2, 15000, 80),
(3, 4, 2, 1500, 50);

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

--
-- Déchargement des données de la table `etatbesoin`
--

INSERT INTO `etatbesoin` (`idEtat`, `refFournisseurEtat`, `date`, `libelle`) VALUES
(1, 1, '2025-06-23', 'rioiuyt ertyuio'),
(3, 3, '2025-06-11', 'poiuiytre'),
(4, 3, '2025-06-26', 'Requisition Jus Afia');

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

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`idFourni`, `noms`, `adresse`, `contact`, `autres`, `username`, `pswd`) VALUES
(1, 'Promesse Mbonyimbuga', 'Virunga', '+243973885864', 'fullstack', 'promesse', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'Mbonyimbuga Promesse', 'Goma', '0854252581', 'web dev', 'prom', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'Dorcas Mbonyi Promesse', 'Goma ville', '039824888', 'devellopeuse', 'Dor', '8d4112ce0aabe7aeef422c136a222624'),
(7, 'Lydie Niyonzima', 'Himbi', '7895118888', 'dataanalyst', 'Lydia', '4ba29b9f9e5732ed33761840f4ba6c53'),
(8, 'Dylan Kavundama', 'Katoyi', '0854252581', 'Mobile dev', 'Dylan', '670b14728ad9902aecba32e22fa4f6bd'),
(9, 'Eliza Magana', 'Virunga', '039824888777', 'styliste', 'IME', 'd47268e9db2e9aa3827bba3afb7ff94a');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `designation`, `PUProduit`, `unite`, `refCategorie`) VALUES
(1, 'Cremica', 200, 'FC', 1),
(2, 'Afia', 1500, 'FC', 2),
(3, 'Apple', 1000, 'FC', 2);

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
(1, 'Dorcas', '202cb962ac59075b964b07152d234b70', 'Admin'),
(2, 'Kizo', '21c3134ee5edcb618c4f9aae358d73a7', 'Admin');

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
  ADD PRIMARY KEY (`idCategorie`);

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
  ADD PRIMARY KEY (`idFourni`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD KEY `fk_categorie` (`refCategorie`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appeloffre`
--
ALTER TABLE `appeloffre`
  MODIFY `idAppel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `idCandidat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `detailetat`
--
ALTER TABLE `detailetat`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  MODIFY `idEtat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `idFourni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
