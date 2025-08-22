<?php
require_once '../bd/conbd.php';

if (isset($_GET['idPaye'])) {
    $idPaye = intval($_GET['idPaye']);

    // === Récupérer paiement + fournisseur + résumé ===
    $stmt = $con->prepare("
        SELECT 
            paye.idPaye,
            f.noms AS fournisseur,
            paye.montantTotal,
            paye.montantVerse,
            paye.reste,
            paye.datePaye,
            e.idEtat
        FROM payement paye
        INNER JOIN etatBesoin e ON paye.refEtatPaye = e.idEtat
        INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
        WHERE paye.idPaye = ?
    ");
    $stmt->execute([$idPaye]);
    $recu = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recu):

        // === Récupérer tous les produits de cet état ===
        $stmt2 = $con->prepare("
            SELECT p.designation, d.Qte, d.PU, (d.Qte*d.PU) AS PT
            FROM detailEtat d
            INNER JOIN produit p ON d.refProduit = p.idProduit
            WHERE d.refEtatDetail = ?
        ");
        $stmt2->execute([$recu['idEtat']]);
        $produits = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .recu { border: 2px solid #000; padding: 20px; width: 700px; margin: auto; }
        .recu h2 { text-align: center; }
        .info { margin-bottom: 10px; }
        .info strong { display: inline-block; width: 150px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: center; }
        .total { font-weight: bold; font-size: 16px; text-align: right; margin-top: 10px; }
        .print-btn { display: none; }
    </style>
</head>
<body onload="window.print()">

    <div class="recu">
        <h2>Reçu de Paiement</h2>
        <div class="info"><strong>Numéro de reçu :</strong> <?= $recu['idPaye'] ?></div>
        <div class="info"><strong>Fournisseur :</strong> <?= htmlspecialchars($recu['fournisseur']) ?></div>
        <div class="info"><strong>Date de paiement :</strong> <?= date("d/m/Y", strtotime($recu['datePaye'])) ?></div>

        <h3>Produits achetés :</h3>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>PU (FC)</th>
                    <th>PT (FC)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $somme = 0;
                foreach($produits as $prod): 
                    $somme += $prod['PT'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($prod['designation']) ?></td>
                    <td><?= $prod['Qte'] ?></td>
                    <td><?= number_format($prod['PU'],2) ?></td>
                    <td><?= number_format($prod['PT'],2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">Montant Total : <?= number_format($recu['montantTotal'],2) ?> FC</div>
        <div class="total">Montant Payé : <?= number_format($recu['montantVerse'],2) ?> FC</div>
        <div class="total">Reste à payer : <?= number_format($recu['reste'],2) ?> FC</div>
    </div>

</body>
</html>
<?php
    else:
        echo "Reçu introuvable.";
    endif;
} else {
    echo "ID invalide.";
}
?>
