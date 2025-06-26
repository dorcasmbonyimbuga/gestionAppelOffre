<?php
require '../auth/authUser.php'; // ou authAdmin si tu veux limiter aux admins
require '../bd/conbd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Rapports</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <style>
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h3>Rapports disponibles</h3>
  <div class="mb-4 no-print">
    <button class="btn btn-primary" onclick="printSection('rapport_fournisseurs')">Fournisseurs</button>
    <button class="btn btn-primary" onclick="printSection('rapport_produits')">Produits</button>
    <button class="btn btn-primary" onclick="printSection('rapport_appels')">Appels d'offres</button>
    <button class="btn btn-primary" onclick="printSection('rapport_candidats')">Candidatures</button>
  </div>

  <!-- Rapport Fournisseurs -->
  <div id="rapport_fournisseurs" class="mb-5">
    <h4>Liste des fournisseurs</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nom</th><th>Adresse</th><th>Contact</th><th>Username</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $con->query("SELECT noms, adresse, contact, username FROM fournisseur ORDER BY noms");
        foreach ($stmt as $f):
        ?>
          <tr>
            <td><?= $f['noms'] ?></td>
            <td><?= $f['adresse'] ?></td>
            <td><?= $f['contact'] ?></td>
            <td><?= $f['username'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Rapport Produits -->
  <div id="rapport_produits" class="mb-5">
    <h4>Liste des produits</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Désignation</th><th>Prix Unitaire</th><th>Catégorie</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $con->query("SELECT designation, PUProduit, unite, categorieProduit.designationCat 
                             FROM produit INNER JOIN categorieProduit 
                             ON produit.refCategorie = categorieProduit.idCategorie");
        foreach ($stmt as $p):
        ?>
          <tr>
            <td><?= $p['designation'] ?></td>
            <td><?= $p['PUProduit'] . ' ' . $p['unite'] ?></td>
            <td><?= $p['designationCat'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Rapport Appels d’offres -->
  <div id="rapport_appels" class="mb-5">
    <h4>Appels d’offres publiés</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Objet</th><th>État de besoin</th><th>Date publication</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $con->query("SELECT objets, autresInfo, datePub, libelle 
                             FROM appelOffre 
                             INNER JOIN etatBesoin ON refEtatAppel = idEtat");
        foreach ($stmt as $a):
        ?>
          <tr>
            <td><?= $a['objets'] ?></td>
            <td><?= $a['libelle'] ?></td>
            <td><?= $a['datePub'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Rapport Candidatures -->
  <div id="rapport_candidats" class="mb-5">
    <h4>Liste des candidatures</h4>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Fournisseur</th><th>Appel d’offre</th><th>Date</th><th>Statut</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $con->query("SELECT f.noms, a.objets, c.dateCandidature, c.statut 
                             FROM candidats c
                             INNER JOIN fournisseur f ON c.refFournisseurCandidat = f.idFourni
                             INNER JOIN appelOffre a ON c.refAppelOffre = a.idAppel");
        foreach ($stmt as $c):
        ?>
          <tr>
            <td><?= $c['noms'] ?></td>
            <td><?= $c['objets'] ?></td>
            <td><?= $c['dateCandidature'] ?></td>
            <td><?= ucfirst($c['statut']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>

<script>
function printSection(sectionId) {
  var printContents = document.getElementById(sectionId).innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload(); // Recharge pour revenir à l'état initial
}
</script>
</body>
</html>
