<?php
// fichier : insert.php
require '../bd/conbd.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Africa/Kinshasa');
$date = date('Y-m-d');
// if ($_POST['table'] === 'detailEtat') {
//     file_put_contents('debug_insert.txt', print_r($_POST, true));
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fournisseur
    if (isset($_POST['table']) && $_POST['table'] === 'fournisseur') {
        $stmt = $con->prepare("INSERT INTO fournisseur (noms, adresse, contact, autres, username, pswd) VALUES (?, ?, ?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['noms'],
            $_POST['adresse'],
            $_POST['contact'],
            $_POST['autres'],
            $_POST['username'],
            md5($_POST['pswd'])
        ]) ? 'success' : 'error';
    }

    // EtatBesoin
    elseif ($_POST['table'] === 'etatBesoin') {
        $stmt = $con->prepare("INSERT INTO etatBesoin (refFournisseurEtat, date, libelle) VALUES (?, ?, ?)");
        echo $stmt->execute([
            $_POST['refFournisseurEtat'],
            $date,
            $_POST['libelle']
        ]) ? 'success' : 'error';
    }

    // CategorieProduit
    elseif ($_POST['table'] === 'categorieProduit') {
        $stmt = $con->prepare("INSERT INTO categorieProduit (designationCat) VALUES (?)");
        echo $stmt->execute([
            $_POST['designationCat']
        ]) ? 'success' : 'error';
    }

    // Produit
    elseif ($_POST['table'] === 'produit') {
        $stmt = $con->prepare("INSERT INTO produit (designation, PUProduit, unite, refCategorie) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['designation'],
            $_POST['PUProduit'],
            $_POST['unite'],
            $_POST['refCategorie']
        ]) ? 'success' : 'error';
    }

    // DetailEtat
    elseif ($_POST['table'] === 'detailEtat') {
        $stmt = $con->prepare("INSERT INTO detailEtat (refEtatDetail, refProduit, PU, Qte) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refEtatDetail'],
            $_POST['refProduit'],
            $_POST['PU'],
            $_POST['Qte']
        ]) ? 'success' : 'error';
    }

    // AppelOffre
    elseif ($_POST['table'] === 'appelOffre') {
        $stmt = $con->prepare("INSERT INTO appelOffre (refEtatAppel, datePub, objets, autresInfo) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refEtatAppel'],
            $date,
            $_POST['objets'],
            $_POST['autresInfo']
        ]) ? 'success' : 'error';
    }

    // Candidats
    elseif ($_POST['table'] === 'candidats') {
        $stmt = $con->prepare("INSERT INTO candidats (refAppelOffre, refFournisseurCandidat, statut, dateCandidature, autresDetails) VALUES (?, ?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refAppelOffre'],
            $_POST['refFournisseurCandidat'],
            $_POST['statut'],
            $date,
            $_POST['autresDetails']
        ]) ? 'success' : 'error';
    }

    // Payement
    elseif ($_POST['table'] === 'payement') {
        $stmt = $con->prepare("INSERT INTO payement (refEtatPaye,refProduitPaye,QtePaye,PUPaye,montantPaye, datePaye) VALUES (?, ?, ?, ?,?,?)");
        echo $stmt->execute([
            $_POST['refEtatPaye'],
            $_POST['refProduitPaye'],
            $_POST['QtePaye'],
            $_POST['PUPaye'],
            $_POST['montantPaye'],
            $date
        ]) ? 'success' : 'error';
    }

    // Paiement
    elseif ($_POST['table'] === 'paiement') {
        $stmt = $con->prepare("INSERT INTO paiement (refEtatPaye, montantTotal, montantVerse, reste, datePaye) VALUES (?, ?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refEtatPaye'],
            $_POST['montantTotal'],
            $_POST['montantVerse'],
            $_POST['reste'],
            $_POST['datePaye']
        ]) ? 'success' : 'error';
    }


    // Utilisateur
    elseif ($_POST['table'] === 'user') {
        $stmt = $con->prepare("INSERT INTO user (username, pswd, niveauAcces) VALUES (?, ?, ?)");
        echo $stmt->execute([
            $_POST['username'],
            md5($_POST['pswd']),
            $_POST['niveauAcces']
        ]) ? 'success' : 'error';
    }
}
?>