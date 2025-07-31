$(document).ready(function () {
  // === AFFICHER MESSAGES FLASH ===
  function showMessage(msg, type = "success") {
    const alertBox = $(`
      <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${msg}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`);
    $("#alertContainer").append(alertBox);
    setTimeout(() => alertBox.alert("close"), 5000);
  }

  // === CHARGER TABLEAUX DYNAMIQUES ===
  function loadTable(table, extraData = {}) {
    $.post("../process/fetch_all.php", { table: table, ...extraData }, function (data) {
      $(`#table_${table} tbody`).html(data);
    }).fail(() => {
      showMessage("Erreur chargement tableau.", "danger");
    });
  }

  $("[id^=table_]").each(function () {
    const id = $(this).attr("id");
    const tableName = id.replace("table_", "");
    loadTable(tableName);
  });

  // === MODAL AJOUT ===
  $(document).on("click", ".btn-add", function () {
    const modalId = $(this).data("modal");
    const form = $(`#${modalId} form`)[0];
    form.reset();
    $(form).find("input[type=hidden][name*=id]").val("");
    $(`#${modalId}`).modal("show");
  });

  // === MODAL ÉDITION ===
  $(document).on("click", ".btn-edit", function () {
    const modalId = $(this).data("modal");
    const table = $(this).data("table");
    const id = $(this).data("id");
    const form = $(`#${modalId} form`)[0];
    $(form).find("input, select, textarea").val("");
    $(form).find('input[name="table"]').val(table);

    $.post("../process/fetch.php", { table: table, id: id }, function (data) {
      if (data) {
        for (const key in data) {
          $(`#${modalId} [name="${key}"]`).val(data[key]);
        }
        $(`#${modalId}`).modal("show");
      } else {
        showMessage("Erreur chargement données.", "danger");
      }
    }, "json").fail(() => {
      showMessage("Erreur serveur.", "danger");
    });
  });

  // === SUPPRESSION ===
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
        $.post("../process/delete.php", { table: table, id: id }, function (resp) {
          if (resp.trim() === "success") {
            showMessage("Suppression réussie.");
            loadTable(table);
          } else {
            showMessage("Erreur lors de la suppression.", "danger");
          }
        }).fail(() => {
          showMessage("Erreur serveur.", "danger");
        });
      }
    });
  });

  // === DETAIL ETAT ===
  function fetchDetailEtat(idEtat) {
    $.post("../process/fetch_all.php", { table: "detailEtat", refEtatDetail: idEtat }, function (data) {
      $("#table_detailEtat tbody").html(data);
    });
  }

  $(document).on("click", ".btn-detail-etat", function () {
    const idEtat = $(this).data("idetat");
    $('#refEtatDetail').val(idEtat);
    $('#modalDetailEtat').modal('show');
    fetchDetailEtat(idEtat);
  });

  $("#formDetailEtat").off("submit").on("submit", function (e) {
    e.preventDefault();
    const form = this;
    const idEtat = $("#refEtatDetail").val();

    $.post("../process/insert.php", $(form).serialize(), function (response) {
      if (response.trim() === "success") {
        fetchDetailEtat(idEtat);
        $("#refProduit, #PU, #Qte").val("");
        showMessage("✅ Détail ajouté !");
      } else {
        showMessage("❌ Erreur : " + response, "danger");
      }
    });
  });

  // === PAYEMENT ===
  function fetchPayement(idEtat) {
    $.post("../process/fetch_all.php", { table: "payement", refEtatPaye: idEtat }, function (data) {
      $("#table_payement tbody").html(data);
    });
  }

  $(document).on("click", ".btn-payement", function () {
    const idEtat = $(this).data("paye");
    $("#refEtatPaye").val(idEtat);
    $("#modalPayement").modal("show");
    fetchPayement(idEtat);
  });

  $("#formPayement").off("submit").on("submit", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation(); // ✅ Empêche le double appel

    const form = this;
    const idEtat = $("#refEtatPaye").val();

    if (!idEtat) {
      showMessage("⚠️ ID État non fourni.", "danger");
      return;
    }

    $.post("../process/insert.php", $(form).serialize(), function (response) {
      if (response.trim() === "success") {
        fetchPayement(idEtat);
        showMessage("💰 Paiement enregistré avec succès !");
        $("#modalPayement").modal("hide");
        loadTable("etatBesoin");
      } else {
        showMessage("❌ Erreur lors de l’enregistrement : " + response, "danger");
      }
    }).fail(() => {
      showMessage("⚠️ Erreur serveur.", "danger");
    });
  });

  // === GESTION GÉNÉRALE DES FORMULAIRES (hors détail & payement) ===
  $(document).off("submit", "form").on("submit", "form", function (e) {
    const id = $(this).attr("id");
    if (id === "formDetailEtat" || id === "formPayement") {
      return;
    }

    e.preventDefault();
    const form = this;
    const modal = $(form).closest(".modal");
    const table = $(form).find('input[name="table"]').val();

    let url = "../process/insert.php";
    const idFields = $(form).find("input[type=hidden]").filter(function () {
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
        if (resp.trim() === "success") {
          showMessage("✅ Opération réussie.");
          modal.modal("hide");
          loadTable(table);
        } else {
          showMessage("❌ Erreur : " + resp, "danger");
        }
      },
      error: function () {
        showMessage("❌ Erreur serveur.", "danger");
      }
    });
  });

});
