<?php
$pageTitle = "Candidat";
$currentPage = "candidat";
$breadcrumb = ["Pages", "Candidat"];
include "../partials/header.php"
?>
<!-- Tableau -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Liste de candidats</h4>
          <button
            class="btn btn-primary btn-round btn-add ms-auto" data-modal="modalCandidats">
            <i class="fa fa-plus"></i>
            Ajouter Candidat
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="table_candidats"
            class="display table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Objet</th>
                <th scope="col">Noms Fournisseur</th>
                <th scope="col">Statut</th>
                <th scope="col">Date</th>
                <th scope="col">Autres</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Contenu chargé par AJAX -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include "../partials/footer.php"; ?>
<!-- Initialisation DataTables -->
<script>
  $(document).ready(function() {
    $('#table_candidats').DataTable();
  });
</script>