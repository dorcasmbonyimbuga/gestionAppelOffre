<?php
$pageTitle = "Rapports";
$currentPage = "rapports";
$breadcrumb = ["Pages", "Rapports"];
include "../partials/header.php";
?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }

    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: center;
    }

    .filter-row label {
        font-weight: 600;
        margin-right: 5px;
    }

    .filter-row input[type="date"] {
        max-width: 200px;
        padding: 5px 10px;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }

    .btn-group .btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Rapports disponibles</h4>
            </div>

            <div class="card-body">
                <!-- BOUTONS -->
                <div class="mb-4 no-print">
                    <div class="mb-2"><strong>Sélectionner un rapport :</strong></div>
                    <div class="btn-group flex-wrap" role="group">
                        <button class="btn btn-primary" onclick="printSection('rapport_fournisseurs')">Fournisseurs</button>
                        <button class="btn btn-primary" onclick="printSection('rapport_produits')">Produits</button>
                        <button class="btn btn-primary" onclick="printSection('rapport_appels')">Appels d'offres</button>
                        <button class="btn btn-primary" onclick="printSection('rapport_candidats')">Candidatures</button>
                        <button class="btn btn-primary" onclick="printSection('rapport_etat')">Etats de besoin</button>
                        <button class="btn btn-primary" onclick="printSection('rapport_paiements')">Paiements</button>
                    </div>
                </div>

                <!-- FILTRES DATES -->
                <div class="filter-row no-print">
                    <div>
                        <label for="dateStart">De :</label>
                        <input type="date" id="dateStart" onchange="autoFilter()">
                    </div>
                    <div>
                        <label for="dateEnd">À :</label>
                        <input type="date" id="dateEnd" onchange="autoFilter()">
                    </div>
                </div>

                <!-- Rapport Fournisseurs -->
                <div id="rapport_fournisseurs" class="mb-5">
                    <h4>Liste des fournisseurs</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Contact</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("SELECT noms, adresse, contact, username FROM fournisseur ORDER BY noms");
                            foreach ($stmt as $f):
                            ?>
                                <tr>
                                    <td><?= $f['noms'] ?></td>
                                    <td><?= $f['adresse'] ?></td>
                                    <td><?= $f['contact'] ?></td>
                                    <td><?= $f['username'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Rapport Produits -->
                <div id="rapport_produits" class="mb-5 date-filter">
                    <h4>Liste des produits</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Prix Unitaire</th>
                                <th>Catégorie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("SELECT designation, PUProduit, unite, categorieProduit.designationCat 
                             FROM produit INNER JOIN categorieProduit 
                             ON produit.refCategorie = categorieProduit.idCategorie");
                            foreach ($stmt as $p):
                            ?>
                                <tr>
                                    <td><?= $p['designation'] ?></td>
                                    <td><?= $p['PUProduit'] . ' ' . $p['unite'] ?></td>
                                    <td><?= $p['designationCat'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Appels d’offres -->
                <div id="rapport_appels" class="mb-5 date-filter">
                    <h4>Appels d’offres publiés</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Objet</th>
                                <th>État de besoin</th>
                                <th>Date publication</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("SELECT objets, autresInfo, datePub, libelle 
                             FROM appelOffre 
                             INNER JOIN etatBesoin ON refEtatAppel = idEtat");
                            foreach ($stmt as $a):
                            ?>
                                <tr>
                                    <td><?= $a['objets'] ?></td>
                                    <td><?= $a['libelle'] ?></td>
                                    <td class="date"><?= $a['datePub'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Candidatures -->
                <div id="rapport_candidats" class="mb-5 date-filter">
                    <h4>Liste des candidatures</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fournisseur</th>
                                <th>Appel d’offre</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("SELECT f.noms, a.objets, c.dateCandidature, c.statut 
                             FROM candidats c
                             INNER JOIN fournisseur f ON c.refFournisseurCandidat = f.idFourni
                             INNER JOIN appelOffre a ON c.refAppelOffre = a.idAppel");
                            foreach ($stmt as $c):
                            ?>
                                <tr>
                                    <td><?= $c['noms'] ?></td>
                                    <td><?= $c['objets'] ?></td>
                                    <td class="date"><?= $c['dateCandidature'] ?></td>
                                    <td><?= ucfirst($c['statut']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- États de besoin -->
                <div id="rapport_etat" class="mb-5 date-filter">
                    <h4>Liste d'états de besoins</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Objet appel</th>
                                <th>Etat de besoin</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>PU</th>
                                <th>Autres Info</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("SELECT a.idAppel,a.objets,e.libelle,p.designation,d.Qte,d.PU,a.autresInfo,a.datePub
                                FROM appeloffre a JOIN etatbesoin e ON a.refEtatAppel = e.idEtat 
                                JOIN detailetat d ON d.refEtatDetail = e.idEtat 
                                JOIN produit p ON d.refProduit = p.idProduit");
                            foreach ($stmt as $a):
                            ?>
                                <tr>
                                    <td><?= $a['objets'] ?></td>
                                    <td><?= $a['libelle'] ?></td>
                                    <td><?= $a['designation'] ?></td>
                                    <td><?= $a['Qte'] ?></td>
                                    <td><?= $a['PU'] ?></td>
                                    <td><?= $a['autresInfo'] ?></td>
                                    <td class="date"><?= $a['datePub'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Rapport Paiements -->
                <div id="rapport_paiements" class="mb-5 date-filter">
                    <h4>Liste des paiements</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fournisseur</th>
                                <th>Produit</th>
                                <th>Quantité payée</th>
                                <th>PU</th>
                                <th>Total payé</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->query("
                                SELECT f.noms, p.designation, paye.QtePaye, paye.PUPaye, 
                                (paye.QtePaye * paye.PUPaye) AS PT, paye.datePaye
                                FROM payement paye
                                INNER JOIN etatBesoin e ON paye.refEtatPaye = e.idEtat
                                INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
                                INNER JOIN produit p ON paye.refProduitPaye = p.idProduit
                                ORDER BY paye.datePaye DESC
                            ");
                            foreach ($stmt as $row):
                            ?>
                                <tr>
                                    <td><?= $row['noms'] ?></td>
                                    <td><?= $row['designation'] ?></td>
                                    <td><?= $row['QtePaye'] ?></td>
                                    <td><?= number_format($row['PUPaye'], 2) ?> FC</td>
                                    <td><?= number_format($row['PT'], 2) ?> FC</td>
                                    <td class="date"><?= $row['datePaye'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include "../partials/footer.php"; ?>

<script>
function autoFilter() {
    const startInput = document.getElementById('dateStart');
    const endInput = document.getElementById('dateEnd');
    const start = new Date(startInput.value);
    const end = new Date(endInput.value);

    if (!startInput.value || !endInput.value) {
        document.querySelectorAll('.date-filter tbody tr').forEach(tr => tr.style.display = '');
        return;
    }

    document.querySelectorAll('.date-filter tbody tr').forEach(row => {
        const dateCell = row.querySelector('.date');
        if (dateCell) {
            const currentDate = new Date(dateCell.textContent.trim());
            if (currentDate >= start && currentDate <= end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

function printSection(sectionId) {
    autoFilter(); // appliquer filtre avant impression
    const printContents = document.getElementById(sectionId).innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>
