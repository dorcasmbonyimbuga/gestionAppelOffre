<?php
require '../bd/conbd.php';

$stmt = $con->query("SELECT f.noms, a.objets, c.dateCandidature
                     FROM candidats c
                     INNER JOIN fournisseur f ON c.refFournisseurCandidat = f.idFourni
                     INNER JOIN appelOffre a ON c.refAppelOffre = a.idAppel
                     ORDER BY c.dateCandidature DESC
                     LIMIT 5");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajout "il y a X minutes"
function timeAgo($datetime) {
  $time = strtotime($datetime);
  $diff = time() - $time;

  if ($diff < 60) return 'il y a quelques secondes';
  elseif ($diff < 3600) return 'il y a ' . floor($diff / 60) . ' minutes';
  elseif ($diff < 86400) return 'il y a ' . floor($diff / 3600) . ' heures';
  else return 'il y a ' . floor($diff / 86400) . ' jours';
}

foreach ($rows as &$row) {
  $row['timeago'] = timeAgo($row['dateCandidature']);
}

echo json_encode($rows);
