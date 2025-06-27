<?php
$pageTitle = "Detail Etat de besoin";
$currentPage = "detailEtat";
$breadcrumb = ["Pages", "Detail Etat de besoin"];
include "../partials/header.php"
?>
<!-- Tableau -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Detail Etat de besoin</h4>
          <button
            class="btn btn-primary btn-round btn-add ms-auto" data-modal="modalDetailEtat">
            <i class="fa fa-plus"></i>
            Ajouter Detail Etat de Besoin
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="table_detailEtat"
            class="display table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Etat besoin</th>
                <th scope="col">Produit</th>
                <th scope="col">PU</th>
                <th scope="col">Quantite</th>
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
    $('#table_detailEtat').DataTable();
  });
</script>