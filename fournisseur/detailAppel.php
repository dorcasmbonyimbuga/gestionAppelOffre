<?php
include "../partials/headerFourni.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "ID invalide.";
  exit;
}

$idAppel = $_GET['id'];
$idFourni = $_SESSION['idFourni'];

// Récupération des infos de l'appel d'offre
$stmt = $con->prepare("SELECT a.idAppel,a.objets,e.libelle,p.designation,d.Qte,d.PU,a.autresInfo,a.datePub
    FROM appeloffre as a JOIN etatbesoin as e ON a.refEtatAppel = e.idEtat JOIN 
    detailetat as d ON d.refEtatDetail = e.idEtat JOIN 
    produit as p ON d.refProduit = p.idProduit WHERE a.idAppel = ?");
$stmt->execute([$idAppel]);
$data = $stmt->fetch();

if (!$data) {
  echo "Aucun appel d'offre trouvé.";
  exit;
}

// Vérifie si le fournisseur a déjà postulé
$check = $con->prepare("SELECT COUNT(*) FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
$check->execute([$idAppel, $idFourni]);
$dejaPostule = $check->fetchColumn() > 0;
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Detail appel d'offre</h4>
        </div>
      </div>
      <div class="card-body">
        <h2><?= htmlspecialchars($data['objets']) ?></h2>
        <p><strong>État de besoin :</strong> <?= htmlspecialchars($data['libelle']) ?></p>
        <p><strong>Désignation du produit :</strong> <?= htmlspecialchars($data['designation']) ?></p>
        <p><strong>Quantité demandée :</strong> <?= htmlspecialchars($data['Qte']) ?></p>
        <p><strong>Prix unitaire :</strong> <?= htmlspecialchars($data['PU']) ?></p>
        <p><strong>Informations complémentaires :</strong> <?= nl2br(htmlspecialchars($data['autresInfo'])) ?></p>
        <p><strong>Date de publication :</strong> <?= $data['datePub'] ?></p>

        <!-- Boutons côte à côte -->
        <div class="d-flex mt-4">
          <a href="listeAppel.php" class="btn btn-secondary me-2">← Retour à la liste</a>
          <a href="postuler.php?idAppel=<?= isset($data['idAppel']) ? $data['idAppel'] : '' ?>"
            class="btn btn-primary <?= $dejaPostule ? 'disabled' : '' ?>">
            Postuler
          </a>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php include "../partials/footerFourni.php"; ?>