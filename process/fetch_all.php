<?php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];

    switch($table){
        case 'fournisseur':
            $stmt = $con->query("SELECT idFourni, noms, adresse, contact, username FROM fournisseur ORDER BY idFourni DESC");
            break;
        case 'categorieProduit':
            $stmt = $con->query("SELECT idCategorie, designation FROM categorieProduit ORDER BY idCategorie DESC");
            break;
        case 'etatBesoin':
            $stmt = $con->query("SELECT idEta, refFournisseur, date, libelle FROM etatBesoin ORDER BY idEta DESC");
            break;
        case 'produit':
            $stmt = $con->query("SELECT idProduit, designation, PU, unite, refCategorie FROM produit ORDER BY idProduit DESC");
            break;
        case 'detailEtat':
            $stmt = $con->query("SELECT idDetail, refEtat, refProduit, PU, Qte FROM detailEtat ORDER BY idDetail DESC");
            break;
        case 'appelOffre':
            $stmt = $con->query("SELECT idAppel, refEtat, date, objets, autres FROM appelOffre ORDER BY idAppel DESC");
            break;
        case 'candidats':
            $stmt = $con->query("SELECT idCandidat, refAppel, refFournisseur, statut, date, autre FROM candidats ORDER BY idCandidat DESC");
            break;
        default:
            echo '<tr><td colspan="100%">Table inconnue</td></tr>';
            exit;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row){
        echo '<tr>';
        foreach ($row as $col) {
            echo '<td>' . htmlspecialchars($col) . '</td>';
        }
        echo '<td>
            <button class="btn btn-warning btn-edit" data-modal="modal'.ucfirst($table).'" data-table="'.$table.'" data-id="'. array_values($row)[0] .'">Modifier</button>
            <button class="btn btn-danger btn-delete" data-table="'.$table.'" data-id="'. array_values($row)[0] .'">Supprimer</button>
        </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="100%">Requête invalide</td></tr>';
}
?>
