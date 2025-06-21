<?php
// fichier : insert.php
require 'pdo.php';

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

// fichier : update.php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'])) {
        $table = $_POST['table'];

        if ($table === 'fournisseur') {
            $stmt = $con->prepare("UPDATE fournisseur SET noms=?, adresse=?, contact=?, autres=?, username=?, pswd=? WHERE idFourni=?");
            echo $stmt->execute([
                $_POST['noms'], $_POST['adresse'], $_POST['contact'], $_POST['autres'],
                $_POST['username'], $_POST['pswd'], $_POST['idFourni']
            ]) ? 'success' : 'error';
        } elseif ($table === 'etatBesoin') {
            $stmt = $con->prepare("UPDATE etatBesoin SET refFournisseur=?, date=?, libelle=? WHERE idEta=?");
            echo $stmt->execute([
                $_POST['refFournisseur'], $_POST['date'], $_POST['libelle'], $_POST['idEta']
            ]) ? 'success' : 'error';
        } elseif ($table === 'categorieProduit') {
            $stmt = $con->prepare("UPDATE categorieProduit SET designation=? WHERE idCategorie=?");
            echo $stmt->execute([
                $_POST['designation'], $_POST['idCategorie']
            ]) ? 'success' : 'error';
        } elseif ($table === 'produit') {
            $stmt = $con->prepare("UPDATE produit SET designation=?, PU=?, unite=?, refCategorie=? WHERE idProduit=?");
            echo $stmt->execute([
                $_POST['designation'], $_POST['PU'], $_POST['unite'], $_POST['refCategorie'], $_POST['idProduit']
            ]) ? 'success' : 'error';
        } elseif ($table === 'detailEtat') {
            $stmt = $con->prepare("UPDATE detailEtat SET refEtat=?, refProduit=?, PU=?, Qte=? WHERE idDetail=?");
            echo $stmt->execute([
                $_POST['refEtat'], $_POST['refProduit'], $_POST['PU'], $_POST['Qte'], $_POST['idDetail']
            ]) ? 'success' : 'error';
        } elseif ($table === 'appelOffre') {
            $stmt = $con->prepare("UPDATE appelOffre SET refEtat=?, date=?, objets=?, autres=? WHERE idAppel=?");
            echo $stmt->execute([
                $_POST['refEtat'], $_POST['date'], $_POST['objets'], $_POST['autres'], $_POST['idAppel']
            ]) ? 'success' : 'error';
        } elseif ($table === 'candidats') {
            $stmt = $con->prepare("UPDATE candidats SET refAppel=?, refFournisseur=?, statut=?, date=?, autre=? WHERE idCandidat=?");
            echo $stmt->execute([
                $_POST['refAppel'], $_POST['refFournisseur'], $_POST['statut'], $_POST['date'], $_POST['autre'], $_POST['idCandidat']
            ]) ? 'success' : 'error';
        }
    }
}

// fichier : delete.php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'], $_POST['id'])) {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $primaryKey = [
            'fournisseur' => 'idFourni',
            'etatBesoin' => 'idEta',
            'categorieProduit' => 'idCategorie',
            'produit' => 'idProduit',
            'detailEtat' => 'idDetail',
            'appelOffre' => 'idAppel',
            'candidats' => 'idCandidat'
        ];

        if (array_key_exists($table, $primaryKey)) {
            $stmt = $con->prepare("DELETE FROM $table WHERE {$primaryKey[$table]} = ?");
            echo $stmt->execute([$id]) ? 'success' : 'error';
        }
    }
}

// fichier : fetch.php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'], $_POST['id'])) {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $primaryKey = [
            'fournisseur' => 'idFourni',
            'etatBesoin' => 'idEta',
            'categorieProduit' => 'idCategorie',
            'produit' => 'idProduit',
            'detailEtat' => 'idDetail',
            'appelOffre' => 'idAppel',
            'candidats' => 'idCandidat'
        ];

        if (array_key_exists($table, $primaryKey)) {
            $stmt = $con->prepare("SELECT * FROM $table WHERE {$primaryKey[$table]} = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
    }
}

