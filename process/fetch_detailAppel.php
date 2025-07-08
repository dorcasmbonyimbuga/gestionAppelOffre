<?php
require_once '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAppel'])) {
    $idAppel = $_POST['idAppel'];
    $stmt = $con->prepare("SELECT d.idDetailAppel, p.designation, d.Qte, d.PU 
        FROM detailAppel d 
        INNER JOIN produit p ON d.refProduit = p.idProduit 
        WHERE d.refAppel = ? ORDER BY d.idDetailAppel DESC");
    $stmt->execute([$idAppel]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['designation']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Qte']) . '</td>';
        echo '<td>' . htmlspecialchars($row['PU']) . '</td>';
        echo '<td>
            <button class="btn btn-danger btn-xs btn-delete-detail" data-id="' . $row['idDetailAppel'] . '"><i class="fas fa-trash"></i></button>
        </td>';
        echo '</tr>';
    }
}
