<?php

require '../bd/conbd.php';
include "../partials/headerFourni.php";
$idFourni = $_SESSION['idFourni'];

$stmt = $con->prepare("
  SELECT appelOffre.objets, appelOffre.datePub, candidats.statut, candidats.dateCandidature
  FROM candidats
  INNER JOIN appelOffre ON candidats.refAppelOffre = appelOffre.idAppel
  WHERE candidats.refFournisseurCandidat = ?
  ORDER BY candidats.dateCandidature DESC
");
$stmt->execute([$idFourni]);
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Candidatures</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
  <h3 class="mb-4">Mes candidatures</h3>

  <?php if (empty($candidatures)): ?>
    <div class="alert alert-info">Vous n'avez encore postulé à aucun appel d'offre.</div>
  <?php else: ?>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Objet Appel</th>
          <th>Date Publication</th>
          <th>Date Candidature</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($candidatures as $cand): ?>
          <tr>
            <td><?= htmlspecialchars($cand['objets']) ?></td>
            <td><?= $cand['datePub'] ?></td>
            <td><?= $cand['dateCandidature'] ?></td>
            <td>
              <?php
                switch ($cand['statut']) {
                  case 'en attente':
                    echo '<span class="badge bg-warning text-dark">En attente</span>';
                    break;
                  case 'reçu':
                    echo '<span class="badge bg-info text-dark">Reçu</span>';
                    break;
                  case 'validé':
                    echo '<span class="badge bg-success">Validé</span>';
                    break;
                  default:
                    echo htmlspecialchars($cand['statut']);
                }
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
