<?php

include("./../dbConnexion/connect.php"); 

if (isset($_POST['connecter'])) {
    $Nom = $_POST['Nom'];
    $MotDePasse = htmlspecialchars($_POST['MotDePasse']);
    
        $sql = ("SELECT * from vUtilisateur WHERE Nom ='$Nom' AND MotDePasse ='$MotDePasse' ");
        $result = mysqli_query($con,$sql);       

        if (mysqli_num_rows($result) > 0) {
            $row=mysqli_fetch_assoc($result);

            $_SESSION['Id'] = (string)$row['Id'];
            $_SESSION['nomMembre'] = $row['nomMembre'];
            $_SESSION['photoMbr'] = $row['photoMbr'];
            $_SESSION['contactMbr'] = $row['contactMbr'];
            $_SESSION['mailMbr'] = $row['mailMbr'];
            $_SESSION['Nom'] = $row['Nom'];
            $_SESSION['MotDePasse'] = $row['MotDePasse'];
            $_SESSION['Fonction'] = $row['Fonction'];
            $_SESSION['categorie'] = $row['categorie'];
            
            header("Location: ./../indexAdmin.php");

        } else {
             header("location: index.php?msg=False&info=Verifier votre Nom d'utilisateur ou mot de passe");
        }
}
else {
    header("location: index.php?msg=False&info=Verifier votre Nom d'utilisateur ou mot de passe");
}