<?php
require '../bd/conbd.php';
$id = $_GET['id'];

$stmt = $con->prepare("SELECT appelOffre.*, etatBesoin.libelle
                       FROM appelOffre
                       INNER JOIN etatBesoin ON appelOffre.refEtatAppel = etatBesoin.idEtat
                       WHERE idAppel = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();
?>

<div class="container">
  <h2><?= htmlspecialchars($data['objets']) ?></h2>
  <p><strong>État de besoin :</strong> <?= htmlspecialchars($data['libelle']) ?></p>
  <p><strong>Informations complémentaires :</strong> <?= nl2br(htmlspecialchars($data['autresInfo'])) ?></p>
  <p><strong>Date publication :</strong> <?= $data['datePub'] ?></p>
  <a href="postuler.php?idAppel=<?= $data['idAppel'] ?>" class="btn btn-success">Postuler</a>
</div>
