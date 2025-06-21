<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Gestion Fournisseurs</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- FontAwesome (optionnel pour icônes) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">

  <h2 class="mb-4">Gestion des Fournisseurs</h2>

  <!-- Bouton Ajouter -->
  <button class="btn btn-primary btn-add mb-3" data-modal="modalFournisseur">
    <i class="fas fa-plus"></i> Ajouter Fournisseur
  </button>

  <!-- Tableau -->
  <table class="table table-bordered" id="table_fournisseur">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Noms</th>
        <th>Adresse</th>
        <th>Contact</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Contenu chargé par AJAX -->
    </tbody>
  </table>

</div>

<!-- Conteneur alert -->
<div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1055; width: 320px;"></div>

<!-- Modal Fournisseur (inclus ici) -->
<?php include 'modal_fournisseur.php'; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap Bundle JS (avec Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

<script>
// Code JS de gestion (extrait adapté)
$(document).ready(function(){

  function showMessage(msg, type = 'success') {
    const alertBox = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">${msg}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`);
    $('#alertContainer').append(alertBox);
    setTimeout(() => alertBox.alert('close'), 5000);
  }

  function loadTable(table){
    $.post('fetch_all.php', {table: table}, function(data){
      $(`#table_${table} tbody`).html(data);
    }).fail(() => {
      showMessage('Erreur chargement tableau.', 'danger');
    });
  }

  loadTable('fournisseur');

  $(document).on('click', '.btn-add', function(){
    const modalId = $(this).data('modal');
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find('input[type=hidden][name*=id]').val('');
    $(`#${modalId}`).modal('show');
  });

  $(document).on('click', '.btn-edit', function(){
    const modalId = $(this).data('modal');
    const table = $(this).data('table');
    const id = $(this).data('id');
    const form = $(`#${modalId} form`)[0];
    $(form).find('input, select, textarea').val('');

    $.post('fetch.php', {table: table, id: id}, function(data){
      if(data){
        for(const key in data){
          $(`#${modalId} [name="${key}"]`).val(data[key]);
        }
        $(`#${modalId}`).modal('show');
      } else {
        showMessage('Erreur chargement données.', 'danger');
      }
    }, 'json').fail(() => {
      showMessage('Erreur serveur.', 'danger');
    });
  });

  $(document).on('submit', 'form', function(e){
    e.preventDefault();
    const form = this;
    const modal = $(form).closest('.modal');
    const table = $(form).find('input[name="table"]').val();
    let url = 'insert.php';

    const idFields = $(form).find('input[type=hidden]').filter(function(){
      return this.name.startsWith('id') && $(this).val() !== '';
    });
    if(idFields.length > 0){
      url = 'update.php';
    }

    $.ajax({
      url: url,
      method: 'POST',
      data: $(form).serialize(),
      success: function(resp){
        if(resp.trim() === 'success'){
          showMessage('Opération réussie.');
          modal.modal('hide');
          loadTable(table);
        } else {
          showMessage('Erreur lors de l\'opération.', 'danger');
        }
      },
      error: function(){
        showMessage('Erreur serveur.', 'danger');
      }
    });
  });

  $(document).on('click', '.btn-delete', function(){
    const table = $(this).data('table');
    const id = $(this).data('id');

    Swal.fire({
      title: 'Confirmer la suppression ?',
      text: "Cette action est irréversible !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimer !',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('delete.php', {table: table, id: id}, function(resp){
          if(resp.trim() === 'success'){
            showMessage('Suppression réussie.');
            loadTable(table);
          } else {
            showMessage('Erreur lors de la suppression.', 'danger');
          }
        }).fail(() => {
          showMessage('Erreur serveur.', 'danger');
        });
      }
    });
  });

});
</script>

</body>
</html>
<!-- appel modals se trouvant dans un fichier -->
 <button class="btn btn-primary btn-add" data-modal="modalFournisseur">Ajouter Fournisseur</button>
<button class="btn btn-warning btn-edit" data-modal="modalProduit" data-table="produit" data-id="12">Modifier Produit</button>
