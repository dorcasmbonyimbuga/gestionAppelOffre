<?php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];

    switch($table){
        case 'fournisseur':
            $stmt = $con->query("SELECT idFourni, noms, adresse, contact, username FROM fournisseur ORDER BY idFourni DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row){
                echo '<tr>';
                echo '<td>'.htmlspecialchars($row['idFourni']).'</td>';
                echo '<td>'.htmlspecialchars($row['noms']).'</td>';
                echo '<td>'.htmlspecialchars($row['adresse']).'</td>';
                echo '<td>'.htmlspecialchars($row['contact']).'</td>';
                echo '<td>'.htmlspecialchars($row['username']).'</td>';
                echo '<td>
                    <button class="btn btn-warning btn-edit" data-modal="modalFournisseur" data-table="fournisseur" data-id="'. $row['idFourni'] .'">Modifier</button>
                    <button class="btn btn-danger btn-delete" data-table="fournisseur" data-id="'. $row['idFourni'] .'">Supprimer</button>
                </td>';
                echo '</tr>';
            }
            break;

        // Ajoute ici d’autres tables selon besoin, même principe

        default:
            echo '<tr><td colspan="6">Table inconnue</td></tr>';
    }
} else {
    echo '<tr><td colspan="6">Requête invalide</td></tr>';
}
?>
