<?php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];

    switch ($table) {
        case 'fournisseur':
            $stmt = $con->query("SELECT idFourni, noms, adresse, contact, username FROM fournisseur ORDER BY idFourni DESC");
            break;
        case 'categorieProduit':
            $stmt = $con->query("SELECT idCategorie, designationCat FROM categorieProduit ORDER BY idCategorie DESC");
            break;
        case 'etatBesoin':
            $stmt = $con->query("SELECT idEtat, fournisseur.noms, date, libelle FROM etatBesoin inner join fournisseur on etatBesoin.refFournisseurEtat=fournisseur.idFourni ORDER BY idEtat DESC");
            break;
        case 'produit':
            $stmt = $con->query("SELECT idProduit, designation, PUProduit, unite, categorieproduit.designationCat FROM produit  inner join categorieproduit on produit.refCategorie=categorieproduit.idCategorie ORDER BY idProduit DESC");
            break;
        case 'detailEtat':
            $stmt = $con->query("SELECT idDetail,etatBesoin.libelle,produit.designation, PU, Qte FROM detailEtat inner join etatBesoin on detailEtat.refEtatDetail=etatBesoin.idEtat inner join produit on detailEtat.refProduit=produit.idProduit ORDER BY idDetail DESC");
            break;
        case 'appelOffre':
            $stmt = $con->query("SELECT idAppel, etatBesoin.libelle, datePub, objets, autresInfo FROM appelOffre inner join etatBesoin on appelOffre.refEtatAppel=etatBesoin.idEtat ORDER BY idAppel DESC");
            break;
        case 'candidats':
            $stmt = $con->query("SELECT idCandidat,appelOffre.objets, fournisseur.noms, statut, dateCandidature, autresDetails FROM candidats inner join fournisseur on candidats.refFournisseurCandidat=fournisseur.idFourni inner join appelOffre on candidats.refAppelOffre=appelOffre.idAppel ORDER BY idCandidat DESC");
            break;
        default:
            echo '<tr><td colspan="100%">Table inconnue</td></tr>';
            exit;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($row as $col) {
            echo '<td>' . htmlspecialchars($col) . '</td>';
        }
        echo '<td>
            <button class="btn btn-primary btn-edit" data-modal="modal' . ucfirst($table) . '" data-table="' . $table . '" data-id="' . array_values($row)[0] . '"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-delete" data-table="' . $table . '" data-id="' . array_values($row)[0] . '"><i class="fas fa-trash-alt"></i></button>
        </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="100%">Requête invalide</td></tr>';
}
