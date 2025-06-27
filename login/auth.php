<?php
session_start();

if (
    (!isset($_SESSION['idUser']) && !isset($_SESSION['idFourni']))
) {
    header('Location: ../login/login.php');
    exit();
}
?>
