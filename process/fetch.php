<?php
// fichier : fetch.php
require '../bd/conbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table'], $_POST['id'])) {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $primaryKey = [
            'fournisseur' => 'idFourni',
            'etatBesoin' => 'idEtat',
            'categorieProduit' => 'idCategorie',
            'produit' => 'idProduit',
            'detailEtat' => 'idDetail',
            'appelOffre' => 'idAppel',
            'candidats' => 'idCandidat',
            'user' => 'idUser'
        ];

        if (array_key_exists($table, $primaryKey)) {
            $stmt = $con->prepare("SELECT * FROM $table WHERE {$primaryKey[$table]} = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
    }
}