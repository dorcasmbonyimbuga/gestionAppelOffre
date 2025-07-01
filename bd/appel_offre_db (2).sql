-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 04:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appel_offre_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appeloffre`
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
-- Table structure for table `candidats`
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
-- Table structure for table `categorieproduit`
--

CREATE TABLE `categorieproduit` (
  `idCategorie` int(11) NOT NULL,
  `designationCat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailetat`
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
-- Table structure for table `etatbesoin`
--

CREATE TABLE `etatbesoin` (
  `idEtat` int(11) NOT NULL,
  `refFournisseurEtat` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `libelle` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fournisseur`
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
-- Table structure for table `produit`
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pswd` varchar(50) NOT NULL,
  `niveauAcces` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `username`, `pswd`, `niveauAcces`) VALUES
(1, 'Admin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin'),
(2, 'Gabriel', 'e10adc3949ba59abbe56e057f20f883e', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeloffre`
--
ALTER TABLE `appeloffre`
  ADD PRIMARY KEY (`idAppel`),
  ADD KEY `fk_etat_appel` (`refEtatAppel`);

--
-- Indexes for table `candidats`
--
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`idCandidat`),
  ADD KEY `fk_appel_offre` (`refAppelOffre`),
  ADD KEY `fk_fourni_candidat` (`refFournisseurCandidat`);

--
-- Indexes for table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  ADD PRIMARY KEY (`idCategorie`),
  ADD UNIQUE KEY `une_categorie` (`designationCat`);

--
-- Indexes for table `detailetat`
--
ALTER TABLE `detailetat`
  ADD PRIMARY KEY (`idDetail`),
  ADD KEY `fk_etat_detail` (`refEtatDetail`),
  ADD KEY `fk_produit` (`refProduit`);

--
-- Indexes for table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  ADD PRIMARY KEY (`idEtat`),
  ADD KEY `fk_fourni_etat` (`refFournisseurEtat`);

--
-- Indexes for table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`idFourni`),
  ADD UNIQUE KEY `un_fournisseur` (`noms`),
  ADD UNIQUE KEY `un_usename_fournisseur` (`username`),
  ADD UNIQUE KEY `un_contact_forunisseur` (`contact`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD UNIQUE KEY `un_produit` (`designation`),
  ADD KEY `fk_categorie` (`refCategorie`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `un_usename_user` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appeloffre`
--
ALTER TABLE `appeloffre`
  MODIFY `idAppel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `idCandidat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailetat`
--
ALTER TABLE `detailetat`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  MODIFY `idEtat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `idFourni` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appeloffre`
--
ALTER TABLE `appeloffre`
  ADD CONSTRAINT `fk_etat_appel` FOREIGN KEY (`refEtatAppel`) REFERENCES `etatbesoin` (`idEtat`);

--
-- Constraints for table `candidats`
--
ALTER TABLE `candidats`
  ADD CONSTRAINT `fk_appel_offre` FOREIGN KEY (`refAppelOffre`) REFERENCES `appeloffre` (`idAppel`),
  ADD CONSTRAINT `fk_fourni_candidat` FOREIGN KEY (`refFournisseurCandidat`) REFERENCES `fournisseur` (`idFourni`);

--
-- Constraints for table `detailetat`
--
ALTER TABLE `detailetat`
  ADD CONSTRAINT `fk_etat_detail` FOREIGN KEY (`refEtatDetail`) REFERENCES `etatbesoin` (`idEtat`),
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`refProduit`) REFERENCES `produit` (`idProduit`);

--
-- Constraints for table `etatbesoin`
--
ALTER TABLE `etatbesoin`
  ADD CONSTRAINT `fk_fourni_etat` FOREIGN KEY (`refFournisseurEtat`) REFERENCES `fournisseur` (`idFourni`);

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`refCategorie`) REFERENCES `categorieproduit` (`idCategorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
