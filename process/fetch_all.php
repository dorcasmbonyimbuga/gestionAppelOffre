<?php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table'])) {
    $table = $_POST['table'];
    $rows = [];

    switch ($table) {
        case 'fournisseur':
            $stmt = $con->query("SELECT idFourni, noms, adresse, contact, username FROM fournisseur ORDER BY idFourni DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'categorieProduit':
            $stmt = $con->query("SELECT idCategorie, designationCat FROM categorieProduit ORDER BY idCategorie DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'etatBesoin':
            $stmt = $con->query("SELECT idEtat, fournisseur.noms, date, libelle FROM etatBesoin inner join fournisseur on etatBesoin.refFournisseurEtat=fournisseur.idFourni ORDER BY idEtat DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'produit':
            $stmt = $con->query("SELECT idProduit, designation, concat(PUProduit,' ',unite) as PUProduit, categorieproduit.designationCat FROM produit inner join categorieproduit on produit.refCategorie=categorieproduit.idCategorie ORDER BY idProduit DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'detailEtat':
            if (isset($_POST['refEtatDetail'])) {
                $idEtat = intval($_POST['refEtatDetail']);
                $stmt = $con->prepare("SELECT idDetail, etatBesoin.libelle, produit.designation, PU, Qte FROM detailEtat inner join etatBesoin on detailEtat.refEtatDetail=etatBesoin.idEtat inner join produit on detailEtat.refProduit=produit.idProduit WHERE refEtatDetail = ? ORDER BY idDetail DESC");
                $stmt->execute([$idEtat]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo '<tr><td colspan="100%">ID État non fourni</td></tr>';
                exit;
            }
            break;

        case 'appelOffre':
            $stmt = $con->query("SELECT idAppel, etatBesoin.libelle, datePub, objets, autresInfo FROM appelOffre inner join etatBesoin on appelOffre.refEtatAppel=etatBesoin.idEtat ORDER BY idAppel DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'candidats':
            $stmt = $con->query("SELECT idCandidat, appelOffre.objets, fournisseur.noms, statut, dateCandidature, autresDetails FROM candidats inner join fournisseur on candidats.refFournisseurCandidat=fournisseur.idFourni inner join appelOffre on candidats.refAppelOffre=appelOffre.idAppel ORDER BY idCandidat DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        // case 'payement':
        //     if (isset($_POST['refEtatPaye']) && !empty($_POST['refEtatPaye'])) {
        //         $idEtat = $_POST['refEtatPaye'];
        //         $stmt = $con->prepare("
        //             SELECT 
        //                 paye.idPaye,
        //                 f.noms AS fournisseur,
        //                 p.designation AS produit,
        //                 paye.QtePaye,
        //                 paye.PUPaye,
        //                 (paye.QtePaye * paye.PUPaye) AS PT,paye.montantPaye,((paye.QtePaye * paye.PUPaye)-montantPaye) as reste,
        //                 paye.datePaye
        //             FROM payement paye
        //             INNER JOIN etatBesoin e ON paye.refEtatPaye = e.idEtat
        //             INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
        //             INNER JOIN produit p ON paye.refProduitPaye = p.idProduit
        //             WHERE paye.refEtatPaye = :idEtat
        //             ORDER BY paye.idPaye DESC
        //         ");
        //         $stmt->execute(['idEtat' => $idEtat]);
        //         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     } else {
        //         echo '<tr><td colspan="100%">ID État non fourni</td></tr>';
        //         exit;
        //     }
        //     break;
// === PAYEMENT : charger détails ===
        case 'payement':
            if (isset($_POST['action']) && $_POST['action'] === 'detail' && isset($_POST['idEtat'])) {
                $idEtat = intval($_POST['idEtat']);

                // 1. Info Etat + Fournisseur
                $stmt = $con->prepare("
            SELECT e.idEtat, e.libelle, f.noms AS fournisseur
            FROM etatbesoin e
            INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
            WHERE e.idEtat = ?
        ");
                $stmt->execute([$idEtat]);
                $etat = $stmt->fetch(PDO::FETCH_ASSOC);

                // 2. Produits (detailEtat)
                $stmt = $con->prepare("
            SELECT p.designation, de.Qte, de.PU, (de.Qte * de.PU) AS total
            FROM detailetat de
            INNER JOIN produit p ON de.refProduit = p.idProduit
            WHERE de.refEtatDetail = ?
        ");
                $stmt->execute([$idEtat]);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 3. Montant total
                $stmt = $con->prepare("SELECT SUM(Qte*PU) FROM detailetat WHERE refEtatDetail=?");
                $stmt->execute([$idEtat]);
                $montantTotal = $stmt->fetchColumn();

                // 4. Déjà payé
                $stmt = $con->prepare("SELECT COALESCE(SUM(montantVerse),0) FROM payement WHERE refEtatPaye=?");
                $stmt->execute([$idEtat]);
                $dejaPaye = $stmt->fetchColumn();

                $reste = $montantTotal - $dejaPaye;

                echo json_encode([
                    "etat" => $etat,
                    "produits" => $produits,
                    "montantTotal" => $montantTotal,
                    "dejaPaye" => $dejaPaye,
                    "reste" => $reste
                ]);
            } else {
                echo json_encode(["error" => "Paramètres invalides"]);
            }
            break;

        // === CHARGER DETAILS POUR PAYEMENT ===
        case 'detailPayement':
            if (isset($_POST['idEtat'])) {
                $idEtat = intval($_POST['idEtat']);

                // 1. Info Etat + Fournisseur
                $stmt = $con->prepare("
            SELECT e.idEtat, e.libelle, f.noms AS fournisseur
            FROM etatbesoin e
            INNER JOIN fournisseur f ON e.refFournisseurEtat = f.idFourni
            WHERE e.idEtat = ?
        ");
                $stmt->execute([$idEtat]);
                $etat = $stmt->fetch(PDO::FETCH_ASSOC);

                // 2. Produits (detailEtat)
                $stmt = $con->prepare("
            SELECT p.designation, de.Qte, de.PU, (de.Qte * de.PU) AS total
            FROM detailetat de
            INNER JOIN produit p ON de.refProduit = p.idProduit
            WHERE de.refEtatDetail = ?
        ");
                $stmt->execute([$idEtat]);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 3. Total
                $stmt = $con->prepare("SELECT SUM(Qte*PU) FROM detailetat WHERE refEtatDetail=?");
                $stmt->execute([$idEtat]);
                $montantTotal = $stmt->fetchColumn();

                // 4. Déjà payé
                $stmt = $con->prepare("SELECT COALESCE(SUM(montantVerse),0) FROM payement WHERE refEtatPaye=?");
                $stmt->execute([$idEtat]);
                $dejaPaye = $stmt->fetchColumn();

                $reste = $montantTotal - $dejaPaye;

                // Retourner en JSON
                echo json_encode([
                    "etat" => $etat,
                    "produits" => $produits,
                    "montantTotal" => $montantTotal,
                    "dejaPaye" => $dejaPaye,
                    "reste" => $reste
                ]);
            } else {
                echo json_encode(["error" => "ID Etat non fourni"]);
            }
            break;


        // === PAYEMENT ===
        case 'payement':
            if (isset($_POST['refEtatPaye'])) {
                $idEtat = intval($_POST['refEtatPaye']);
                $stmt = $con->prepare("
            SELECT idPaye, montantTotal, montantVerse, reste, datePaye
            FROM payement
            WHERE refEtatPaye = ?
            ORDER BY idPaye DESC
        ");
                $stmt->execute([$idEtat]);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($rows) {
                    foreach ($rows as $row) {
                        echo "<tr>
                        <td>{$row['idPaye']}</td>
                        <td>{$row['montantTotal']}</td>
                        <td>{$row['montantVerse']}</td>
                        <td>{$row['reste']}</td>
                        <td>{$row['datePaye']}</td>
                      </tr>";
                    }
                } else {
                    echo '<tr><td colspan="100%">Aucun payement trouvé</td></tr>';
                }
            } else {
                echo '<tr><td colspan="100%">ID État non fourni</td></tr>';
                exit;
            }
            break;


        case 'user':
            $stmt = $con->query("SELECT idUser, username, niveauAcces FROM user ORDER BY idUser DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        default:
            echo '<tr><td colspan="100%">Table inconnue</td></tr>';
            exit;
    }

    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($row as $col) {
            echo '<td>' . htmlspecialchars($col) . '</td>';
        }

        echo '<td>';

        if ($table === 'etatBesoin') {
            echo '<button class="btn btn-success btn-xs btn-detail-etat" 
                 data-idetat="' . $row['idEtat'] . '" 
                 data-bs-toggle="modal" 
                 data-bs-target="#modalDetailEtat" 
                 title="Ajouter Détail">
              <i class="fas fa-plus"></i>
          </button> ';

            echo '<button class="btn btn-secondary btn-xs btn-payement" 
                 data-idetat="' . $row['idEtat'] . '" 
                 data-bs-toggle="modal" 
                 data-bs-target="#modalPayement" 
                 title="Payement">
              <i class="fas fa-hand-holding-usd"></i>
          </button> ';
        }


        if ($table !== 'payement') {
            echo '<button class="btn btn-primary btn-xs btn-edit" data-modal="modal' . ucfirst($table) . '" data-table="' . $table . '" data-id="' . array_values($row)[0] . '" title="Modifier"><i class="fas fa-edit"></i></button> ';
            echo '<button class="btn btn-danger btn-xs btn-delete" data-table="' . $table . '" data-id="' . array_values($row)[0] . '" title="Supprimer"><i class="fas fa-trash-alt"></i></button> ';
        }

        if ($table === 'payement') {
            echo '<a href="printRecu.php?idPaye=' . $row['idPaye'] . '" class="btn btn-info btn-xs" target="_blank" title="Imprimer Reçu"><i class="fas fa-print"></i></a>';
        }

        echo '</td>';
        echo '</tr>';
    }
}
