<?php
require '../bd/conbd.php';
include "../partials/headerFourni.php";
$idFourni = $_SESSION['idFourni']; // doit être défini au login

// Récupérer les appels d’offres avec état de besoin
$stmt = $con->query("SELECT appelOffre.idAppel, etatBesoin.libelle, datePub, objets, autresInfo
                    FROM appelOffre
                    INNER JOIN etatBesoin ON appelOffre.refEtatAppel = etatBesoin.idEtat
                    ORDER BY idAppel DESC");
$appels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$pageTitle = "Fournisseur";
$currentPage = "listeAppel";
$breadcrumb = ["Fournisseur", "Liste Appel d'offre"];

?>
<!-- Tableau -->
<div class="row">
  <?php foreach ($appels as $index => $appel): ?>
    <?php
    $check = $con->prepare("SELECT COUNT(*) FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
    $check->execute([$appel['idAppel'], $idFourni]);
    $dejaPostule = $check->fetchColumn() > 0;
    ?>
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?= htmlspecialchars($appel['objets']) ?></h5>
          <p class="card-text"><strong>Besoin :</strong> <?= htmlspecialchars($appel['libelle']) ?></p>
          <p><strong>Infos :</strong> <?= nl2br(htmlspecialchars($appel['autresInfo'])) ?></p>
          <p class="mt-auto"><small>Publié le : <?= $appel['datePub'] ?></small></p>
          
          <!-- ✅ Boutons côte à côte -->
          <div class="d-flex justify-content-between mt-2">
            <a href="detail_appel.php?id=<?= $appel['idAppel'] ?>" class="btn btn-secondary btn-sm flex-fill me-2">Voir plus</a>
            <!-- <a href="details_appel.php?id=<?= $appel['idAppel'] ?>" class="btn btn-secondary btn-sm flex-fill me-2">Voir plus</a> -->
            <a href="postuler.php?idAppel=<?= $appel['idAppel'] ?>" class="btn btn-primary btn-sm flex-fill <?= $dejaPostule ? 'disabled' : '' ?>">
              <?= $dejaPostule ? 'Déjà postulé' : 'Postuler' ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</div>
</div>




<?php include "../partials/footerFourni.php"; ?>