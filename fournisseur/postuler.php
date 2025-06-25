<?php
session_start();
require '../bd/conbd.php';

$idAppel = $_GET['idAppel'];
$idFournisseur = $_SESSION['id_fournisseur'];

// Vérifie si déjà postulé
$stmt = $con->prepare("SELECT * FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
$stmt->execute([$idAppel, $idFournisseur]);

if ($stmt->rowCount() > 0) {
    echo "<div class='alert alert-info'>Vous avez déjà postulé à cet appel d’offre.</div>";
    exit;
}
?>

<div class="container">
    <h3>Soumettre votre candidature</h3>
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

<script>
    $(document).ready(function () {
  $('#form-candidature').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: '../process/insert_candidature.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        $('#resultat-candidature').html('<div class="alert alert-success">Votre candidature a été soumise avec succès.</div>');
        $('#form-candidature').hide();
      },
      error: function () {
        $('#resultat-candidature').html('<div class="alert alert-danger">Une erreur est survenue.</div>');
      }
    });
  });
});

</script>