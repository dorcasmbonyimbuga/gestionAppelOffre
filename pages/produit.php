<?php
$pageTitle = "Produit";
$currentPage = "produit";
$breadcrumb = ["Pages", "Produit"];
include "../partials/header.php"
?>
<!-- Tableau -->
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Liste de Produits</h4>
          <button
            class="btn btn-primary btn-round btn-add ms-auto" data-modal="modalProduit">
            <i class="fa fa-plus"></i>
            Ajouter Produit
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="table_produit"
            class="display table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Désignation</th>
                <th scope="col">PU</th>
                <th scope="col">Catégorie</th>
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
  <!-- Tableau categorie produit -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h4 class="card-title">Catégorie</h4>
          <button
            class="btn btn-primary btn-round btn-add ms-auto" data-modal="modalCategorieProduit">
            <i class="fa fa-plus"></i>
            Ajouter
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="table_categorieProduit"
            class="display table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Désign</th>
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

<?php include "../partials/footer.php"; ?>
<!-- Initialisation DataTables -->
<script>
  $(document).ready(function() {
    $('#table_produit').DataTable();
    $('#table_categorieProduit').DataTable();
  });
</script>