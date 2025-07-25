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
            $stmt = $con->query("SELECT idProduit, designation, concat(PUProduit,' ',unite) as PUProduit, categorieproduit.designationCat FROM produit  inner join categorieproduit on produit.refCategorie=categorieproduit.idCategorie ORDER BY idProduit DESC");
            break;
        case 'detailEtat':
            if (isset($_POST['refEtatDetail'])) {
                $idEtat = intval($_POST['refEtatDetail']);
                $stmt = $con->prepare("SELECT idDetail, etatBesoin.libelle, produit.designation, PU, Qte FROM detailEtat inner join etatBesoin on detailEtat.refEtatDetail=etatBesoin.idEtat inner join produit on detailEtat.refProduit=produit.idProduit WHERE refEtatDetail = ? ORDER BY idDetail DESC");
                $stmt->execute([$idEtat]);
            } else {
                echo '<tr><td colspan="100%">ID État non fourni</td></tr>';
                exit;
            }
            break;
        case 'appelOffre':
            $stmt = $con->query("SELECT idAppel, etatBesoin.libelle, datePub, objets, autresInfo FROM appelOffre inner join etatBesoin on appelOffre.refEtatAppel=etatBesoin.idEtat ORDER BY idAppel DESC");
            break;
        case 'candidats':
            $stmt = $con->query("SELECT idCandidat, appelOffre.objets, fournisseur.noms, statut, dateCandidature, autresDetails FROM candidats inner join fournisseur on candidats.refFournisseurCandidat=fournisseur.idFourni inner join appelOffre on candidats.refAppelOffre=appelOffre.idAppel ORDER BY idCandidat DESC");
            break;
        case 'payement':
            $stmt = $con->query("SELECT idPaye, f.noms, p.designation, QtePaye, PUPaye, (QtePaye * PUPaye) as PT, datePaye FROM payement paye inner join fournisseur f on paye.refFourniPaye=f.idFourni inner join produit p on paye.refProduitPaye=p.idProduit ORDER BY idPaye DESC");
            break;
        case 'user':
            $stmt = $con->query("SELECT idUser, username, niveauAcces FROM user ORDER BY idUser DESC");
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

        echo '<td>';

        if ($table === 'etatBesoin') {
            echo '<button class="btn btn-success btn-xs btn-detail-etat" data-idetat="' . $row['idEtat'] . '" data-bs-toggle="modal" data-bs-target="#modalDetailEtat" title="Ajouter Détail"><i class="fas fa-plus"></i></button> ';
            echo '<button class="btn btn-secondary btn-xs btn-payement" data-paye="' . $row['idEtat'] . '" data-bs-toggle="modal" data-bs-target="#modalPayement" title="Payement"><i class="fas fa-hand-holding-usd"></i></button> ';
        }

        if ($table !== 'payement') {
            echo '<button class="btn btn-primary btn-xs btn-edit" data-modal="modal' . ucfirst($table) . '" data-table="' . $table . '" data-id="' . array_values($row)[0] . '" title="Modifier"><i class="fas fa-edit"></i></button> ';
            echo '<button class="btn btn-danger btn-xs btn-delete" data-table="' . $table . '" data-id="' . array_values($row)[0] . '" title="Supprimer"><i class="fas fa-trash-alt"></i></button> ';
        }

        if ($table === 'payement') {
            echo '<a href="printRecu.php?idPaye=' . $row['idPaye'] . '" class="btn btn-info btn-xs" target="_blank" title="Imprimer Reçu"><i class="fas fa-print"></i></a>';
        }

        echo '</td>';
        echo '</tr>';
    }
}
