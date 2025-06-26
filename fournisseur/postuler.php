<?php
require '../bd/conbd.php';
include "../partials/headerFourni.php";

$idAppel = $_GET['idAppel'];
$idFournisseur = $_SESSION['idFourni'];

// Vérifie si déjà postulé
$stmt = $con->prepare("SELECT * FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
$stmt->execute([$idAppel, $idFournisseur]);

if ($stmt->rowCount() > 0) {
  echo "<div class='alert alert-info'>Vous avez déjà postulé à cet appel d’offre.</div>";
  exit;
}
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Soumettre votre candidature</h4>
        </div>
      </div>
      <div class="card-body">
        <form id="form-candidature">
          <input type="hidden" name="refFournisseurCandidat" value="<?= $idFournisseur ?>">
          <input type="hidden" name="refAppelOffre" value="<?= $idAppel ?>">

          <div class="form-group mb-3">
            <label for="autresDetails">Votre proposition</label>
            <textarea class="form-control" name="autresDetails" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>

        <!-- zone d'affichage du résultat -->
        <div id="resultat-candidature" class="mt-3"></div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<?php include "../partials/footerFourni.php"; ?>

<script>
  $(document).ready(function() {
    $('#form-candidature').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: '../process/insertCandidature.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          $('#resultat-candidature').html('<div class="alert alert-success">Votre candidature a été soumise avec succès. Redirection...</div>');
          $('#form-candidature').hide();

          setTimeout(function() {
            window.location.href = 'listeAppel.php';
          }, 3000);
        },
        error: function() {
          $('#resultat-candidature').html('<div class="alert alert-danger">Une erreur est survenue.</div>');
        }
      });
    });
  });
</script>
