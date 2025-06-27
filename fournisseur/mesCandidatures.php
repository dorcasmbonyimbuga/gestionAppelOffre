<?php
$pageTitle = "Mes candidatures";
$currentPage = "mesCandidatures";
$breadcrumb = ["Pages", "Mes candidatures"];

include "../partials/headerFourni.php";
$idFourni = $_SESSION['idFourni'];

$stmt = $con->prepare("
  SELECT appelOffre.objets, appelOffre.datePub, candidats.statut, candidats.dateCandidature
  FROM candidats
  INNER JOIN appelOffre ON candidats.refAppelOffre = appelOffre.idAppel
  WHERE candidats.refFournisseurCandidat = ?
  ORDER BY candidats.dateCandidature DESC
");
$stmt->execute([$idFourni]);
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Mes candidatures</h4>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($candidatures)): ?>
                    <div class="alert alert-info">Vous n'avez encore postulé à aucun appel d'offre.</div>
                <?php else: ?>
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Objet Appel</th>
                                <th>Date Publication</th>
                                <th>Date Candidature</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($candidatures as $cand): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cand['objets']) ?></td>
                                    <td><?= $cand['datePub'] ?></td>
                                    <td><?= $cand['dateCandidature'] ?></td>
                                    <td>
                                        <?php
                                        switch ($cand['statut']) {
                                            case 'en attente':
                                                echo '<span class="badge bg-warning text-dark">En attente</span>';
                                                break;
                                            case 'Reçu':
                                                echo '<span class="badge bg-info text-dark">Reçu</span>';
                                                break;
                                            case 'Validé':
                                                echo '<span class="badge bg-success">Validé</span>';
                                                break;
                                            default:
                                                echo htmlspecialchars($cand['statut']);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php include "../partials/footerFourni.php"; ?>