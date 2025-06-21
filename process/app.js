// Exemple de code JS/AJAX (avec jQuery et SweetAlert2)
$(document).ready(function(){

  // Fonction générique pour afficher un message temporaire
  function showMessage(msg, type = 'success') {
    const alertBox = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">${msg}</div>`);
    $('#alertContainer').append(alertBox);
    setTimeout(() => {
      alertBox.alert('close');
    }, 5000);
  }

  // Ouvrir modal pour ajout
  $('.btn-add').click(function(){
    const modalId = $(this).data('modal');
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find('input[type=hidden][name*=id]').val(''); // vider l'id caché
    $(`#${modalId}`).modal('show');
  });

  // Ouvrir modal pour édition avec données chargées
  $('.btn-edit').click(function(){
    const modalId = $(this).data('modal');
    const table = $(this).data('table');
    const id = $(this).data('id');
    const form = $(`#${modalId} form`)[0];
    $(form).find('input, select, textarea').val(''); // reset formulaire

    // Fetch données pour pré-remplir le formulaire
    $.post('fetch.php', {table: table, id: id}, function(data){
      if(data){
        for(const key in data){
          $(`#${modalId} [name="${key}"]`).val(data[key]);
        }
        $(`#${modalId}`).modal('show');
      } else {
        showMessage('Erreur lors du chargement des données.', 'danger');
      }
    }, 'json').fail(() => {
      showMessage('Erreur serveur lors du chargement.', 'danger');
    });
  });

  // Gestion envoi formulaire (insert/update)
  $('form').submit(function(e){
    e.preventDefault();
    const form = this;
    const modal = $(form).closest('.modal');
    const table = $(form).find('input[name="table"]').val();
    let url = 'insert.php';

    // Si l'id caché a une valeur, c'est une modification
    const idFields = $(form).find('input[type=hidden]').filter(function(){
      return this.name.startsWith('id') && $(this).val() !== '';
    });
    if(idFields.length > 0){
      url = 'update.php';
    }

    // Envoi AJAX
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

  // Suppression avec SweetAlert2
  $('.btn-delete').click(function(){
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

  // Fonction pour recharger le tableau (à adapter pour chaque table)
  function loadTable(table){
    // Exemple : on pourrait faire un appel AJAX pour récupérer HTML tableau ou JSON et le recharger.
    // Ici, tu dois adapter selon ta manière d'afficher les tableaux.
    // Exemple simplifié (à remplacer par ton code spécifique) :
    $.post('fetch_all.php', {table: table}, function(data){
      $(`#table_${table}`).html(data);
    }).fail(() => {
      showMessage('Erreur chargement tableau.', 'danger');
    });
  }

});



// important btns

<button class="btn btn-primary btn-add" data-modal="modalFournisseur">Ajouter Fournisseur</button>

<!-- Dans ton tableau -->
<button class="btn btn-warning btn-edit" data-modal="modalFournisseur" data-table="fournisseur" data-id="123">Modifier</button>

<button class="btn btn-danger btn-delete" data-table="fournisseur" data-id="123">Supprimer</button>


// container html
<div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1055;"></div>


// 1. Conteneur d’alertes (à placer dans le <body> de ta page principale)

<!-- Conteneur des messages flash -->
<div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1055; width: 300px;"></div>

// 2. Exemple d’affichage HTML pour la table fournisseur
<!-- Bouton ajouter -->
<button class="btn btn-primary btn-add" data-modal="modalFournisseur">Ajouter Fournisseur</button>

<!-- Tableau fournisseurs -->
<table class="table table-bordered mt-3" id="table_fournisseur">
  <thead>
    <tr>
      <th>ID</th><th>Noms</th><th>Adresse</th><th>Contact</th><th>Username</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Les données seront chargées ici via AJAX -->
  </tbody>
</table>

<!-- Inclure modal fournisseur (modal_fournisseur.php) ici -->
<?php include 'modal_fournisseur.php'; ?>

// 3. Script PHP fetch_all.php

<?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];

    switch($table){
        case 'fournisseur':
            $stmt = $con->query("SELECT idFourni, noms, adresse, contact, username FROM fournisseur ORDER BY idFourni DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($rows as $row){
                echo '<tr>';
                echo '<td>'.htmlspecialchars($row['idFourni']).'</td>';
                echo '<td>'.htmlspecialchars($row['noms']).'</td>';
                echo '<td>'.htmlspecialchars($row['adresse']).'</td>';
                echo '<td>'.htmlspecialchars($row['contact']).'</td>';
                echo '<td>'.htmlspecialchars($row['username']).'</td>';
                echo '<td>
                    <button class="btn btn-warning btn-edit" data-modal="modalFournisseur" data-table="fournisseur" data-id="'. $row['idFourni'] .'">Modifier</button>
                    <button class="btn btn-danger btn-delete" data-table="fournisseur" data-id="'. $row['idFourni'] .'">Supprimer</button>
                </td>';
                echo '</tr>';
            }
            break;

        // Ajoute ici d’autres tables selon besoin, même principe

        default:
            echo '<tr><td colspan="6">Table inconnue</td></tr>';
    }
} else {
    echo '<tr><td colspan="6">Requête invalide</td></tr>';
}
?>

// 4. Script JS complet (place-le en bas de la page ou dans un fichier JS externe)
$(document).ready(function(){

  // Conteneur alert
  function showMessage(msg, type = 'success') {
    const alertBox = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">${msg}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`);
    $('#alertContainer').append(alertBox);
    setTimeout(() => alertBox.alert('close'), 5000);
  }

  // Charger tableau
  function loadTable(table){
    $.post('fetch_all.php', {table: table}, function(data){
      $(`#table_${table} tbody`).html(data);
    }).fail(() => {
      showMessage('Erreur chargement tableau.', 'danger');
    });
  }

  // Initial load for fournisseur
  loadTable('fournisseur');

  // Ajouter : reset modal + ouvrir
  $(document).on('click', '.btn-add', function(){
    const modalId = $(this).data('modal');
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find('input[type=hidden][name*=id]').val('');
    $(`#${modalId}`).modal('show');
  });

  // Modifier : charger données + ouvrir modal
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

  // Soumission formulaire insert/update
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

  // Suppression avec SweetAlert2
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
