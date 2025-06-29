<?php
// fichier : update.php
require '../bd/conbd.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Africa/Kinshasa');
$date = date('Y-m-d');
// file_put_contents('log_post.txt', print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'])) {
        $table = $_POST['table'];

        if ($table === 'fournisseur') {
            $stmt = $con->prepare("UPDATE fournisseur SET noms=?, adresse=?, contact=?, autres=?, username=?, pswd=? WHERE idFourni=?");
            echo $stmt->execute([
                $_POST['noms'], $_POST['adresse'], $_POST['contact'], $_POST['autres'],
                $_POST['username'], md5($_POST['pswd']), $_POST['idFourni']
            ]) ? 'success' : 'error';
        } elseif ($table === 'etatBesoin') {
            $stmt = $con->prepare("UPDATE etatBesoin SET refFournisseurEtat=?, date=?, libelle=? WHERE idEtat=?");
            echo $stmt->execute([
                $_POST['refFournisseurEtat'], $date, $_POST['libelle'], $_POST['idEtat']
            ]) ? 'success' : 'error';
        } elseif ($table === 'categorieProduit') {
            $stmt = $con->prepare("UPDATE categorieProduit SET designationCat=? WHERE idCategorie=?");
            echo $stmt->execute([
                $_POST['designationCat'], $_POST['idCategorie']
            ]) ? 'success' : 'error';
        } elseif ($table === 'produit') {
            $stmt = $con->prepare("UPDATE produit SET designation=?, PUProduit=?, unite=?, refCategorie=? WHERE idProduit=?");
            echo $stmt->execute([
                $_POST['designation'], $_POST['PUProduit'], $_POST['unite'], $_POST['refCategorie'], $_POST['idProduit']
            ]) ? 'success' : 'error';
        } elseif ($table === 'detailEtat') {
            $stmt = $con->prepare("UPDATE detailEtat SET refEtatDetail=?, refProduit=?, PU=?, Qte=? WHERE idDetail=?");
            echo $stmt->execute([
                $_POST['refEtatDetail'], $_POST['refProduit'], $_POST['PU'], $_POST['Qte'], $_POST['idDetail']
            ]) ? 'success' : 'error';
        } elseif ($table === 'appelOffre') {
            $stmt = $con->prepare("UPDATE appelOffre SET refEtatAppel=?, datePub=?, objets=?, autresInfo=? WHERE idAppel=?");
            echo $stmt->execute([
                $_POST['refEtatAppel'], $date, $_POST['objets'], $_POST['autresInfo'], $_POST['idAppel']
            ]) ? 'success' : 'error';
        } elseif ($table === 'candidats') {
            $stmt = $con->prepare("UPDATE candidats SET refAppelOffre=?, refFournisseurCandidat=?, statut=?, dateCandidature=?, autresDetails=? WHERE idCandidat=?");
            echo $stmt->execute([
                $_POST['refAppelOffre'], $_POST['refFournisseurCandidat'], $_POST['statut'], $date, $_POST['autresDetails'], $_POST['idCandidat']
            ]) ? 'success' : 'error';
        } elseif ($table === 'user') {
            $stmt = $con->prepare("UPDATE user SET username=?, pswd=?, niveauAcces=? WHERE idUser=?");
            echo $stmt->execute([
                $_POST['username'], md5($_POST['pswd']), $_POST['niveauAcces'], $_POST['idUser']
            ]) ? 'success' : 'error';
        }
    }
}

?>
