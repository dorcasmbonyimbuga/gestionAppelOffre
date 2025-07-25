$(document).ready(function () {
  // === AFFICHER MESSAGES FLASH ===
  function showMessage(msg, type = "success") {
    const alertBox = $(
      `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${msg}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`
    );
    $("#alertContainer").append(alertBox);
    setTimeout(() => alertBox.alert("close"), 5000);
  }
  $(".btn-detail-etat").data("idetat");
  $(".btn-detail-etat").attr("data-idetat");
    $(".btn-payement").data("idetat");
  $(".btn-payement").attr("data-paye");

  // === CHARGER TABLEAUX DYNAMIQUES ===
  function loadTable(table) {
    $.post("../process/fetch_all.php", { table: table }, function (data) {
      $(`#table_${table} tbody`).html(data);
    }).fail(() => {
      showMessage("Erreur chargement tableau.", "danger");
    });
  }

  // Initialiser tous les tableaux présents dans la page
  $("[id^=table_]").each(function () {
    const id = $(this).attr("id"); // ex: table_etatBesoin
    const tableName = id.replace("table_", "");
    loadTable(tableName);
  });

  // === AJOUT MODAL ===
  $(document).on("click", ".btn-add", function () {
    const modalId = $(this).data("modal");
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find("input[type=hidden][name*=id]").val("");
    $(`#${modalId}`).modal("show");
  });

  // === ÉDITION MODAL ===
  $(document).on("click", ".btn-edit", function () {
    const modalId = $(this).data("modal");
    const table = $(this).data("table");
    const id = $(this).data("id");
    const form = $(`#${modalId} form`)[0];

    $(form).find("input, select, textarea").val("");
    $(form).find('input[name="table"]').val(table);

    $.post(
      "../process/fetch.php",
      { table: table, id: id },
      function (data) {
        if (data) {
          for (const key in data) {
            $(`#${modalId} [name="${key}"]`).val(data[key]);
          }
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

  // === SOUMISSION FORMULAIRE AJOUT OU MODIFICATION ===
  $(document).on("submit", "form:not(#formDetailEtat)", function (e) {
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

  // === SUPPRESSION AVEC SWEETALERT ===
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

// ===================== DETAIL ETAT BESOIN =======================

// Quand on clique sur le bouton "Ajouter Détail"
$(document).on("click", ".btn-detail-etat", function () {
  const idEtat = $(this).data("idetat");

  console.log("ID capturé :", idEtat);

  // 👉 Supprimer les anciens événements pour éviter double exécution
  $('#modalDetailEtat').off('shown.bs.modal');

  $('#modalDetailEtat').on('shown.bs.modal', function () {
    $('#refEtatDetail').val(idEtat);
    console.log("Valeur insérée :", $('#refEtatDetail').val());
    fetchDetailEtat(idEtat);
  });

  // Ouvrir le modal
  $("#modalDetailEtat").modal("show");
});
// ===========================================
// ===================== PAYEMENT =======================
$(document).on("click", ".btn-payement", function () {
  const idEtat = $(this).data("paye");

  console.log("ID état pour payement :", idEtat);

  // Réinitialiser le formulaire du payement
  const form = $("#modalPayement form")[0];
  form.reset();

  // Remplir le champ caché avec l'id de l'état besoin
  $("#refEtatPaye").val(idEtat);

  // Afficher le modal
  $("#modalPayement").modal("show");
});
// submit du formulaire de detail état


$("#formDetailEtat").on("submit", function (e) {
  e.preventDefault();
  const form = this;

  console.log("📝 Données envoyées :", $(form).serialize());

  $.post("../process/insert.php", $(form).serialize(), function (response) {
    const idEtat = $("#refEtatDetail").val();

    if (response.trim() === "success") {
      fetchDetailEtat(idEtat);
      $("#refProduit, #PU, #Qte").val("");
      showMessage("✅ Détail ajouté !");
    } else {
      showMessage("❌ Erreur : " + response, "danger");
    }
  });
});
// submit du formulaire de payement
$("#formPayement").on("submit", function (e) {
  e.preventDefault();
  const form = this;

  console.log("📤 Envoi du formulaire de payement :", $(form).serialize());

  $.post("../process/insert.php", $(form).serialize(), function (response) {
    if (response.trim() === "success") {
      showMessage("💰 Paiement enregistré avec succès !");
      $("#modalPayement").modal("hide");
      loadTable("etatBesoin"); // Recharge la table liée si besoin
    } else {
      showMessage("❌ Erreur lors de l’enregistrement : " + response, "danger");
    }
  }).fail(() => {
    showMessage("⚠️ Erreur serveur.", "danger");
  });
});

function fetchDetailEtat(idEtat) {
  $.post(
    "../process/fetch_all.php",
    { table: "detailEtat", refEtatDetail: idEtat },
    function (data) {
      $("#table_detailEtat tbody").html(data);
    }
  );
}


});
