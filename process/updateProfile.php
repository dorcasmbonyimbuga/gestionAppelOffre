<?php
include '../login/auth.php';
require '../bd/conbd.php';

$id = $_SESSION['idFourni'] ?? null;
$idUser = $_SESSION['idUser'] ?? null;

if (!$id) {
  http_response_code(403);
  exit("Non autorisé");
}

switch ($_POST['action']) {
  // Modification du profile du fournisseur
  case 'update_infos':
    $stmt = $con->prepare("UPDATE fournisseur SET noms = ?, adresse = ?, contact = ?, autres = ? WHERE idFourni = ?");
    $stmt->execute([
      $_POST['noms'], $_POST['adresse'], $_POST['contact'], $_POST['autres'], $id
    ]);
    $_SESSION['noms'] = $_POST['noms'];
    echo "infos updated";
    break;

  case 'update_username':
    $stmt = $con->prepare("UPDATE fournisseur SET username = ? WHERE idFourni = ?");
    $stmt->execute([$_POST['newUsername'], $id]);
    $_SESSION['username'] = $_POST['newUsername'];
    $_SESSION['noms'] = $_POST['newUsername'];
    echo "username updated";
    break;

  case 'update_password':
    $stmt = $con->prepare("UPDATE fournisseur SET pswd = ? WHERE idFourni = ?");
    $stmt->execute([md5($_POST['newPassword']), $id]);
    echo "password updated";
    break;
// Modification du profile du user
  case 'update_username_user':
    $stmt = $con->prepare("UPDATE user SET username = ? WHERE idFourni = ?");
    $stmt->execute([$_POST['newUsername'], $id]);
    $_SESSION['username'] = $_POST['newUsername'];
    $_SESSION['noms'] = $_POST['newUsername'];
    echo "username updated";
    break;

  case 'update_password_user':
    $stmt = $con->prepare("UPDATE user SET pswd = ? WHERE idFourni = ?");
    $stmt->execute([md5($_POST['newPassword']), $id]);
    echo "password updated";
    break;
}
