<?php
require_once '../bd/conbd.php';

if (isset($_GET['idPaye'])) {
    $idPaye = $_GET['idPaye'];

    $stmt = $con->prepare("
        SELECT 
            paye.idPaye,
            f.noms AS fournisseur,
            p.designation AS produit,
            paye.QtePaye,
            paye.PUPaye,
            (paye.QtePaye * paye.PUPaye) AS PT,
            paye.datePaye
        FROM payement paye
        INNER JOIN etatBesoin e ON paye.refEtatPaye = e.idEtat
        INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
        INNER JOIN produit p ON paye.refProduitPaye = p.idProduit
        WHERE paye.idPaye = ?
    ");
    $stmt->execute([$idPaye]);
    $recu = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recu):
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .recu { border: 2px solid #000; padding: 20px; width: 600px; margin: auto; }
        .recu h2 { text-align: center; }
        .info { margin-bottom: 15px; }
        .info strong { display: inline-block; width: 150px; }
        .total { font-weight: bold; font-size: 18px; text-align: right; margin-top: 20px; }
        .print-btn { display: none; }
    </style>
</head>
<body onload="window.print()">

    <div class="recu">
        <h2>Reçu de Paiement</h2>
        <div class="info"><strong>Numéro de reçu :</strong> <?= $recu['idPaye'] ?></div>
        <div class="info"><strong>Fournisseur :</strong> <?= htmlspecialchars($recu['fournisseur']) ?></div>
        <div class="info"><strong>Produit :</strong> <?= htmlspecialchars($recu['produit']) ?></div>
        <div class="info"><strong>Quantité :</strong> <?= $recu['QtePaye'] ?></div>
        <div class="info"><strong>Prix Unitaire :</strong> <?= number_format($recu['PUPaye'], 2) ?> FC</div>
        <div class="info"><strong>Date de paiement :</strong> <?= date("d/m/Y", strtotime($recu['datePaye'])) ?></div>
        <div class="total">Montant total : <?= number_format($recu['PT'], 2) ?> FC</div>
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
