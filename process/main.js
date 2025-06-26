// main.js
$(document).ready(function () {
  // Affichage message flash
  function showMessage(msg, type = "success") {
    const alertBox =
      $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">${msg}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`);
    $("#alertContainer").append(alertBox);
    setTimeout(() => alertBox.alert("close"), 5000);
  }

  // Charger un tableau (fonction générique)
  function loadTable(table) {
    $.post("../process/fetch_all.php", { table: table }, function (data) {
      $(`#table_${table} tbody`).html(data);
    }).fail(() => {
      showMessage("Erreur chargement tableau.", "danger");
    });
  }

  // Initialiser tous les tableaux présents dans la page
  $("[id^=table_]").each(function () {
    const id = $(this).attr("id"); // ex: table_fournisseur
    const tableName = id.replace("table_", "");
    loadTable(tableName);
  });

  // Ouvrir modal pour ajout (reset formulaire)
  $(document).on("click", ".btn-add", function () {
    const modalId = $(this).data("modal");
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find("input[type=hidden][name*=id]").val("");
    $(`#${modalId}`).modal("show");
  });

  // Ouvrir modal pour édition (charger données)
  $(document).on("click", ".btn-edit", function () {
    const modalId = $(this).data("modal");
    const table = $(this).data("table");
    const id = $(this).data("id");
    const form = $(`#${modalId} form`)[0];

    // 1. Vider les champs du formulaire
    $(form).find("input, select, textarea").val("");

    // ✅ 2. Remettre la valeur du champ "table" correctement
    $(form).find('input[name="table"]').val(table);

    // 3. Charger les données depuis la base
    $.post(
      "../process/fetch.php",
      { table: table, id: id },
      function (data) {
        if (data) {
          // 4. Remplir les champs avec les données reçues
          for (const key in data) {
            $(`#${modalId} [name="${key}"]`).val(data[key]);
          }

          // 5. Afficher le modal
          $(`#${modalId}`).modal("show");
        } else {
          showMessage("Erreur chargement données.", "danger");
        }
      },
      "json"
    ).fail(() => {
      showMessage("Erreur serveur.", "danger");
    });
  });

  // Notifications
  function chargerNotifications() {
    $.ajax({
      url: "../process/get_notifications.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        let html = "";
        if (data.length === 0) {
          html =
            '<div class="notif-center"><span class="dropdown-item">Aucune notification</span></div>';
        } else {
          html += '<div class="notif-center">';
          data.forEach((notif) => {
            html += `
            <a href="#">
              <div class="notif-content">
                <span class="block">${notif.noms}</span>
                <span class="block">${notif.objets}</span>
                <span class="time">${notif.timeago}</span>
              </div>
            </a>`;
          });
          html += "</div>";
        }

        $("#notif-container").html(html);
        $("#notif-count").text(data.length);
      },
    });
  }

  setInterval(chargerNotifications, 15000);
  $(document).ready(chargerNotifications);

  // Gestion soumission formulaire (insert ou update)
  $(document).on("submit", "form", function (e) {
    e.preventDefault();
    const form = this;
    const modal = $(form).closest(".modal");
    const table = $(form).find('input[name="table"]').val();
    let url = "../process/insert.php";

    const idFields = $(form)
      .find("input[type=hidden]")
      .filter(function () {
        return this.name.startsWith("id") && $(this).val() !== "";
      });

    if (idFields.length > 0) {
      url = "../process/update.php";
    }

    $.ajax({
      url: url,
      method: "POST",
      data: $(form).serialize(),
      success: function (resp) {
        console.log("Réponse du serveur:", resp);
        if (resp.trim() === "success") {
          showMessage("Opération réussie.");
          modal.modal("hide");
          loadTable(table);
        } else {
          showMessage("Erreur lors de l'opération: " + resp, "danger");
        }
      },
      error: function (xhr, status, error) {
        console.log("Erreur AJAX:", error);
        showMessage("Erreur serveur.", "danger");
      },
    });
  });

  // Suppression avec SweetAlert2
  $(document).on("click", ".btn-delete", function () {
    const table = $(this).data("table");
    const id = $(this).data("id");

    Swal.fire({
      title: "Confirmer la suppression ?",
      text: "Cette action est irréversible !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Oui, supprimer !",
      cancelButtonText: "Annuler",
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          "../process/delete.php",
          { table: table, id: id },
          function (resp) {
            if (resp.trim() === "success") {
              showMessage("Suppression réussie.");
              loadTable(table);
            } else {
              showMessage("Erreur lors de la suppression.", "danger");
            }
          }
        ).fail(() => {
          showMessage("Erreur serveur.", "danger");
        });
      }
    });
  });
});
console.log($(form).serialize());
