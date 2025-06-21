<?php
// fichier : insert.php
require '../bd/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fournisseur
    if (isset($_POST['table']) && $_POST['table'] === 'fournisseur') {
        $stmt = $con->prepare("INSERT INTO fournisseur (noms, adresse, contact, autres, username, pswd) VALUES (?, ?, ?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['noms'], $_POST['adresse'], $_POST['contact'],
            $_POST['autres'], $_POST['username'], $_POST['pswd']
        ]) ? 'success' : 'error';
    }

    // EtatBesoin
    elseif ($_POST['table'] === 'etatBesoin') {
        $stmt = $con->prepare("INSERT INTO etatBesoin (refFournisseur, date, libelle) VALUES (?, ?, ?)");
        echo $stmt->execute([
            $_POST['refFournisseur'], $_POST['date'], $_POST['libelle']
        ]) ? 'success' : 'error';
    }

    // CategorieProduit
    elseif ($_POST['table'] === 'categorieProduit') {
        $stmt = $con->prepare("INSERT INTO categorieProduit (designation) VALUES (?)");
        echo $stmt->execute([
            $_POST['designation']
        ]) ? 'success' : 'error';
    }

    // Produit
    elseif ($_POST['table'] === 'produit') {
        $stmt = $con->prepare("INSERT INTO produit (designation, PU, unite, refCategorie) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['designation'], $_POST['PU'], $_POST['unite'], $_POST['refCategorie']
        ]) ? 'success' : 'error';
    }

    // DetailEtat
    elseif ($_POST['table'] === 'detailEtat') {
        $stmt = $con->prepare("INSERT INTO detailEtat (refEtat, refProduit, PU, Qte) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refEtat'], $_POST['refProduit'], $_POST['PU'], $_POST['Qte']
        ]) ? 'success' : 'error';
    }

    // AppelOffre
    elseif ($_POST['table'] === 'appelOffre') {
        $stmt = $con->prepare("INSERT INTO appelOffre (refEtat, date, objets, autres) VALUES (?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refEtat'], $_POST['date'], $_POST['objets'], $_POST['autres']
        ]) ? 'success' : 'error';
    }

    // Candidats
    elseif ($_POST['table'] === 'candidats') {
        $stmt = $con->prepare("INSERT INTO candidats (refAppel, refFournisseur, statut, date, autre) VALUES (?, ?, ?, ?, ?)");
        echo $stmt->execute([
            $_POST['refAppel'], $_POST['refFournisseur'], $_POST['statut'], $_POST['date'], $_POST['autre']
        ]) ? 'success' : 'error';
    }
}
?>
