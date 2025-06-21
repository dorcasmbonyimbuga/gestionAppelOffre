<!-- Modal -->
 <!--  1. Ton form dans un modal Bootstrap (exemple) -->
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAdd">
                <div class="modal-header">
                    <h5>Ajouter une distribution</h5>
                </div>
                <div class="modal-body">
                    <!-- Tes champs ici -->
                    <input name="nomBeneS" class="form-control" required>
                    <!-- autres champs... -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  2. JS pour gestion de formulaire + fermeture + reload + message -->
<script>
    $(document).ready(function() {
        $('#formAdd').submit(function(e) {
            e.preventDefault();

            $.post('insert.php', $(this).serialize(), function(response) {
                if (response === "success") {
                    $('#modalAdd').modal('hide'); // Ferme le modal
                    showMessage("Ajout réussi !");
                    loadTable(); // Recharge le tableau
                } else {
                    showMessage("Erreur d'insertion.");
                }
            });
        });
    });

    // Message temporaire
    function showMessage(msg) {
        const alert = $('<div class="alert alert-success">' + msg + '</div>').appendTo('body');
        setTimeout(() => alert.fadeOut(500, () => alert.remove()), 5000);
    }

    // Recharger les données du tableau
    function loadTable() {
        $.post('display_data.php', {
            displaySendDistr: 1
        }, function(data) {
            $('#dataContainer').html(data); // Conteneur de ton tableau
        });
    }
</script>

<!--  3. JS pour suppression avec SweetAlert + reload tableau -->
<script>
    function deleteMembre(id) {
        Swal.fire({
            title: "Supprimer ?",
            text: "Cette action est irréversible.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Oui, supprimer"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('delete.php', {
                    deletesend: id
                }, function(response) {
                    if (response === "success") {
                        Swal.fire({
                            title: "Supprimé !",
                            icon: "success",
                            timer: 5000,
                            showConfirmButton: false
                        });
                        loadTable();
                    } else {
                        Swal.fire("Erreur", "Suppression échouée.", "error");
                    }
                });
            }
        });
    }
</script>

<!-- 4. PHP (Exemple insert.php simplifié) -->
<!-- insert.php -->
<?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $con->prepare("INSERT INTO tdistribution (codeBenef, codeDon, Qte_montant_distr, unite_devise, lieuDistr, adresseLieuDistr, dateDistr)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    echo $stmt->execute([
        $_POST['nomBeneS'], $_POST['donDS'], $_POST['MontantQS'],
        $_POST['DeviseDS'], $_POST['lieuS'], $_POST['adresseDS'], $_POST['DateDistrS']
    ]) ? "success" : "error";
}
?>

<!-- 5. display_data.php pour afficher le tableau dynamiquement -->
<!-- Display read.php -->
 <?php
require 'pdo.php';

if (isset($_POST['displaySendDistr'])) {
    $stmt = $con->prepare("SELECT * FROM vdistribution");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="table table-bordered"><thead><tr>
            <th>#</th><th>Nom</th><th>Don</th><th>Actions</th></tr></thead><tbody>';
    foreach ($data as $row) {
        echo "<tr>
                <td>{$row['codeDistr']}</td>
                <td>{$row['codeBenef']}</td>
                <td>{$row['designationDon']}</td>
                <td>
                    <button onclick='deleteMembre({$row['codeDistr']})' class='btn btn-danger'>Supprimer</button>
                </td>
              </tr>";
    }
    echo '</tbody></table>';
}
?>

<!-- html -->
 <div id="dataContainer">
  <!-- Le tableau sera chargé ici dynamiquement -->
</div>


<!-- ======================================================= -->
 <?php
// pdo.php
try {
    $con = new PDO("mysql:host=localhost;dbname=jh_db", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}
?>

 <!-- insert -->
 <?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $con->prepare("INSERT INTO tdistribution (codeBenef, codeDon, Qte_montant_distr, unite_devise, lieuDistr, adresseLieuDistr, dateDistr)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([
        $_POST['nomBeneS'], $_POST['donDS'], $_POST['MontantQS'],
        $_POST['DeviseDS'], $_POST['lieuS'], $_POST['adresseDS'], $_POST['DateDistrS']
    ])) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
<!-- fetch -->
 <?php
require 'pdo.php';

if (isset($_POST['updateidMbr'])) {
    $stmt = $con->prepare("SELECT * FROM tmembre WHERE codeMbr = ?");
    $stmt->execute([$_POST['updateidMbr']]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
?>
<!-- delete -->
 <?php
require 'pdo.php';

if (isset($_POST['deletesend'])) {
    $stmt = $con->prepare("DELETE FROM tmembre WHERE codeMbr = ?");
    echo $stmt->execute([$_POST['deletesend']]) ? "success" : "error";
}
?>
<!-- example insert -->
 <script>
    $('#form').submit(function(e) {
    e.preventDefault();
    $.post('insert.php', $(this).serialize(), function(response) {
        showMessage(response === "success" ? "Insertion réussie !" : "Erreur lors de l'insertion");
    });
});

function showMessage(msg) {
    const alert = $('<div class="alert alert-info">' + msg + '</div>').appendTo('body');
    setTimeout(() => alert.fadeOut(500, () => alert.remove()), 5000);
}

 </script>
<!-- example delete -->
 <script>
    function deleteMembre(id) {
    Swal.fire({
        title: "Supprimer ce membre ?",
        text: "Cette action est irréversible.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Oui, supprimer",
        cancelButtonText: "Annuler"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('delete.php', { deletesend: id }, function(response) {
                if (response === "success") {
                    Swal.fire({
                        title: "Supprimé !",
                        text: "Le membre a été supprimé.",
                        icon: "success",
                        timer: 5000,
                        showConfirmButton: false
                    });
                    // Optionnel : recharger la liste après suppression
                } else {
                    Swal.fire("Erreur", "Suppression échouée.", "error");
                }
            });
        }
    });
}

 </script>
 <style>
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    padding: 15px;
    border-radius: 5px;
    background: #dff0d8;
    color: #3c763d;
}
</style>


<!-- =================================== -->

<!-- modal insert update -->
 <!-- MODAL COMMUN -->
<div class="modal fade" id="modalForm" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formDistr">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Nouvelle distribution</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="codeDistr" id="codeDistr"> <!-- utilisé uniquement pour l'édition -->

          <label>Nom bénéficiaire</label>
          <input type="text" name="codeBenef" id="codeBenef" class="form-control mb-2" required>

          <label>Don</label>
          <input type="text" name="codeDon" id="codeDon" class="form-control mb-2" required>

          <label>Quantité / Montant distribué</label>
          <input type="text" name="Qte_montant_distr" id="Qte_montant_distr" class="form-control mb-2" required>

          <label>Devise</label>
          <input type="text" name="unite_devise" id="unite_devise" class="form-control mb-2">

          <label>Lieu</label>
          <input type="text" name="lieuDistr" id="lieuDistr" class="form-control mb-2">

          <label>Adresse</label>
          <input type="text" name="adresseLieuDistr" id="adresseLieuDistr" class="form-control mb-2">

          <label>Date de distribution</label>
          <input type="date" name="dateDistr" id="dateDistr" class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="saveBtn">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- bouton add new -->
 <button class="btn btn-success" onclick="openAddModal()">Ajouter</button>
<!-- boutonedit dans le tableau -->
 <button class='btn btn-warning' onclick='openEditModal(<?= $row["codeDistr"] ?>)'>Modifier</button>


<!-- logique du modal -->
 <script>
    // Mode insertion
function openAddModal() {
    $('#modalTitle').text('Nouvelle distribution');
    $('#formDistr')[0].reset();
    $('#codeDistr').val('');
    $('#modalForm').modal('show');
}

// Mode édition
function openEditModal(id) {
    $.post('fetch_one.php', { updateidDistr: id }, function (data) {
        const record = JSON.parse(data);
        $('#modalTitle').text('Modifier la distribution');
        $('#codeDistr').val(record.codeDistr);
        $('#codeBenef').val(record.codeBenef);
        $('#codeDon').val(record.codeDon);
        $('#Qte_montant_distr').val(record.Qte_montant_distr);
        $('#unite_devise').val(record.unite_devise);
        $('#lieuDistr').val(record.lieuDistr);
        $('#adresseLieuDistr').val(record.adresseLieuDistr);
        $('#dateDistr').val(record.dateDistr);
        $('#modalForm').modal('show');
    });
}

// Soumission formulaire AJAX pour ajout ou modification
$('#formDistr').submit(function (e) {
    e.preventDefault();
    $.post('save_distr.php', $(this).serialize(), function (response) {
        if (response === "success") {
            $('#modalForm').modal('hide');
            showMessage("Opération réussie !");
            loadTable();
        } else {
            showMessage("Erreur lors de l'opération.");
        }
    });
});

 </script>

 <!-- fichier save_update.php -->
  <?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['codeDistr'])) {
        // Mode modification
        $stmt = $con->prepare("UPDATE tdistribution SET 
            codeBenef=?, codeDon=?, Qte_montant_distr=?, unite_devise=?, lieuDistr=?, adresseLieuDistr=?, dateDistr=?
            WHERE codeDistr=?");
        $success = $stmt->execute([
            $_POST['codeBenef'], $_POST['codeDon'], $_POST['Qte_montant_distr'],
            $_POST['unite_devise'], $_POST['lieuDistr'], $_POST['adresseLieuDistr'],
            $_POST['dateDistr'], $_POST['codeDistr']
        ]);
    } else {
        // Mode insertion
        $stmt = $con->prepare("INSERT INTO tdistribution (codeBenef, codeDon, Qte_montant_distr, unite_devise, lieuDistr, adresseLieuDistr, dateDistr)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $_POST['codeBenef'], $_POST['codeDon'], $_POST['Qte_montant_distr'],
            $_POST['unite_devise'], $_POST['lieuDistr'], $_POST['adresseLieuDistr'],
            $_POST['dateDistr']
        ]);
    }

    echo $success ? "success" : "error";
}
?>

<!-- fetch-one -->
 <?php
require 'pdo.php';

if (isset($_POST['updateidDistr'])) {
    $stmt = $con->prepare("SELECT * FROM tdistribution WHERE codeDistr = ?");
    $stmt->execute([$_POST['updateidDistr']]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
?>
<!-- fonction js pour afficher le message -->
 <script>
    function showMessage(msg) {
    const alert = $('<div class="alert alert-success">' + msg + '</div>').appendTo('body');
    setTimeout(() => alert.fadeOut(500, () => alert.remove()), 5000);
}

// rechargement des donnees
function loadTable() {
    $.post('display_data.php', { displaySendDistr: 1 }, function (data) {
        $('#dataContainer').html(data);
    });
}

 </script>