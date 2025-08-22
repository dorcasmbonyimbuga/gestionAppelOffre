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
</div>

<!-- table payement -->
CREATE TABLE payement (
  idPaye INT AUTO_INCREMENT PRIMARY KEY,
  refEtatPaye INT NOT NULL,         -- lien vers l'état de besoin
  montantTotal DOUBLE NOT NULL,     -- somme totale de tous les detailEtat de cet état
  montantVerse DOUBLE NOT NULL,     -- montant versé dans ce payement (peut être partiel)
  reste DOUBLE NOT NULL,            -- reste à payer après ce versement
  datePaye DATE NOT NULL,
  CONSTRAINT fk_payement_etat FOREIGN KEY (refEtatPaye) REFERENCES etatbesoin(idEtat)
);

<!-- tableau contenant les detailEtats -->
SELECT p.designation, de.Qte, de.PU, (de.Qte * de.PU) AS total
FROM detailetat de
INNER JOIN produit p ON de.refProduit = p.idProduit
WHERE de.refEtatDetail = :idEtat;

<!-- calcul du total -->
 SELECT SUM(de.Qte * de.PU) AS montantTotal
FROM detailetat de
WHERE de.refEtatDetail = :idEtat;

<!-- calcul reste -->
SELECT COALESCE(SUM(montantVerse), 0) AS dejaPaye
FROM payement
WHERE refEtatPaye = :idEtat;

<!-- Example dans le modal -->
 <div class="modal-body">
  <h6>Détails de l'état de besoin</h6>
  <table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th>Produit</th><th>Qté</th><th>PU</th><th>Total</th>
      </tr>
    </thead>
    <tbody id="detailEtatBody">
      <!-- rempli via AJAX -->
    </tbody>
  </table>

  <div class="mt-3">
    <p><b>Total à payer :</b> <span id="montantTotal"></span></p>
    <p><b>Déjà payé :</b> <span id="dejaPaye"></span></p>
    <p><b>Reste :</b> <span id="reste"></span></p>
  </div>

  <div class="form-group">
    <label>Montant versé :</label>
    <input type="number" id="montantVerse" class="form-control">
  </div>
</div>
<!-- Insert payement -->
 case 'savePayement':
    $idEtat = intval($_POST['idEtat']);
    $montantVerse = doubleval($_POST['montantVerse']);
    $datePaye = date('Y-m-d');

    // 1. Calculer le montant total
    $stmt = $con->prepare("SELECT SUM(Qte*PU) FROM detailetat WHERE refEtatDetail=?");
    $stmt->execute([$idEtat]);
    $montantTotal = $stmt->fetchColumn();

    // 2. Déjà payé
    $stmt = $con->prepare("SELECT COALESCE(SUM(montantVerse),0) FROM payement WHERE refEtatPaye=?");
    $stmt->execute([$idEtat]);
    $dejaPaye = $stmt->fetchColumn();

    // 3. Calculer reste
    $reste = $montantTotal - ($dejaPaye + $montantVerse);

    // 4. Insérer
    $stmt = $con->prepare("INSERT INTO payement(refEtatPaye,montantTotal,montantVerse,reste,datePaye)
                           VALUES(?,?,?,?,?)");
    $stmt->execute([$idEtat,$montantTotal,$montantVerse,$reste,$datePaye]);
    echo "ok";
    break;



<?php include "../partials/footer.php"; ?>
<!-- Initialisation DataTables -->
<script>
  $(document).ready(function() {
    $('#table_detailEtat').DataTable();
  });
</script>