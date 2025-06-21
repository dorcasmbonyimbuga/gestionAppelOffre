<?php
// fichier : update.php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'])) {
        $table = $_POST['table'];

        if ($table === 'fournisseur') {
            $stmt = $con->prepare("UPDATE fournisseur SET noms=?, adresse=?, contact=?, autres=?, username=?, pswd=? WHERE idFourni=?");
            echo $stmt->execute([
                $_POST['noms'], $_POST['adresse'], $_POST['contact'], $_POST['autres'],
                $_POST['username'], $_POST['pswd'], $_POST['idFourni']
            ]) ? 'success' : 'error';
        } elseif ($table === 'etatBesoin') {
            $stmt = $con->prepare("UPDATE etatBesoin SET refFournisseur=?, date=?, libelle=? WHERE idEta=?");
            echo $stmt->execute([
                $_POST['refFournisseur'], $_POST['date'], $_POST['libelle'], $_POST['idEta']
            ]) ? 'success' : 'error';
        } elseif ($table === 'categorieProduit') {
            $stmt = $con->prepare("UPDATE categorieProduit SET designation=? WHERE idCategorie=?");
            echo $stmt->execute([
                $_POST['designation'], $_POST['idCategorie']
            ]) ? 'success' : 'error';
        } elseif ($table === 'produit') {
            $stmt = $con->prepare("UPDATE produit SET designation=?, PU=?, unite=?, refCategorie=? WHERE idProduit=?");
            echo $stmt->execute([
                $_POST['designation'], $_POST['PU'], $_POST['unite'], $_POST['refCategorie'], $_POST['idProduit']
            ]) ? 'success' : 'error';
        } elseif ($table === 'detailEtat') {
            $stmt = $con->prepare("UPDATE detailEtat SET refEtat=?, refProduit=?, PU=?, Qte=? WHERE idDetail=?");
            echo $stmt->execute([
                $_POST['refEtat'], $_POST['refProduit'], $_POST['PU'], $_POST['Qte'], $_POST['idDetail']
            ]) ? 'success' : 'error';
        } elseif ($table === 'appelOffre') {
            $stmt = $con->prepare("UPDATE appelOffre SET refEtat=?, date=?, objets=?, autres=? WHERE idAppel=?");
            echo $stmt->execute([
                $_POST['refEtat'], $_POST['date'], $_POST['objets'], $_POST['autres'], $_POST['idAppel']
            ]) ? 'success' : 'error';
        } elseif ($table === 'candidats') {
            $stmt = $con->prepare("UPDATE candidats SET refAppel=?, refFournisseur=?, statut=?, date=?, autre=? WHERE idCandidat=?");
            echo $stmt->execute([
                $_POST['refAppel'], $_POST['refFournisseur'], $_POST['statut'], $_POST['date'], $_POST['autre'], $_POST['idCandidat']
            ]) ? 'success' : 'error';
        }
    }
}

?>
