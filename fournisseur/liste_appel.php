<?php
session_start();
require '../bd/conbd.php';

$idFournisseur = $_SESSION['idFourni']; // doit être défini au login

// Récupérer les appels d’offres avec état de besoin
$stmt = $con->query("SELECT appelOffre.idAppel, etatBesoin.libelle, datePub, objets, autresInfo
                    FROM appelOffre
                    INNER JOIN etatBesoin ON appelOffre.refEtatAppel = etatBesoin.idEtat
                    ORDER BY idAppel DESC");
$appels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
  <div class="row">
    <?php foreach ($appels as $appel): ?>
      <?php
        // Vérifie si ce fournisseur a déjà postulé à cet appel
        $check = $con->prepare("SELECT COUNT(*) FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
        $check->execute([$appel['idAppel'], $idFournisseur]);
        $dejaPostule = $check->fetchColumn() > 0;
      ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($appel['objets']) ?></h5>
            <p class="card-text"><strong>Besoin :</strong> <?= htmlspecialchars($appel['libelle']) ?></p>
            <p><strong>Infos :</strong> <?= nl2br(htmlspecialchars($appel['autresInfo'])) ?></p>
            <p><small>Publié le : <?= $appel['datePub'] ?></small></p>
            <a href="details_appel.php?id=<?= $appel['idAppel'] ?>" class="btn btn-primary btn-sm">Voir plus</a>
            <a href="postuler.php?idAppel=<?= $appel['idAppel'] ?>" class="btn btn-success btn-sm <?= $dejaPostule ? 'disabled' : '' ?>">
              <?= $dejaPostule ? 'Déjà postulé' : 'Postuler' ?>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
