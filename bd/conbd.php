<?php
try {
    $con = new PDO('mysql:host=127.0.0.1;charset=utf8;dbname=appel_offre_db', 'root', '');
} catch (PDOException $ex) {
    echo "Connection failed: " . $e->getMessage();
    //die pour fermer le script 
    die();
}
