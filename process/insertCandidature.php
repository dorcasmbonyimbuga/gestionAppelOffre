<?php
require '../bd/conbd.php';
session_start();

$refF = $_POST['refFournisseurCandidat'];
$refAppel = $_POST['refAppelOffre'];
$autresDetails = $_POST['autresDetails'];
$date = date('Y-m-d');

// Vérifie doublon
$verif = $con->prepare("SELECT * FROM candidats WHERE refAppelOffre = ? AND refFournisseurCandidat = ?");
$verif->execute([$refAppel, $refF]);

if ($verif->rowCount() > 0) {
  http_response_code(409); // conflit
  echo "Déjà postulé";
  exit;
}

// Insert
$insert = $con->prepare("INSERT INTO candidats (refAppelOffre, refFournisseurCandidat, statut, dateCandidature, autresDetails) VALUES (?, ?, 'en attente', ?, ?)");
if ($insert->execute([$refAppel, $refF, $date, $autresDetails])) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Erreur";
}
