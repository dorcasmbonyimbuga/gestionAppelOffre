<?php

$con=new mysqli('localhost','root','','jh_db');

if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($con,$_POST['Nom']);
    $MotDePasse=md5($_POST['MotDePasse']);
    //$fonction=$_POST['Fonction'];
    $RefMbr=$_POST['RefMbr'];

    $select=" SELECT * FROM tutilisateur WHERE Nom='$name' && RefMbr='$RefMbr'";

    $result=mysqli_query($con,$select);

    if(mysqli_num_rows($result) > 0){
        $error[]='Ce compte existe deja !';
    }
    else{
        $insert="INSERT INTO tutilisateur(Nom,MotDePasse,Fonction,RefMbr) VALUES ('$name','$MotDePasse','Membre','$RefMbr')";
        mysqli_query($con,$insert);
        header('location:index.php');
    }
};

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ASBL - Jeunes Humanitaires</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./../img/New/logoJH.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="includes-login/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="includes-login/css/fontawesome-all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="includes-login/font/flaticon.css" >
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
 
    <section class="fxt-template-animation fxt-template-layout33">
        <div class="fxt-content-wrap">
            <div class="fxt-heading-content">
                <div class="fxt-inner-wrap fxt-transformX-R-50 fxt-transition-delay-3">
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                        <a href="login-33.html" class="fxt-logo"><img src="includes-login/img/jh2.png" alt="Logo"></a>
                    </div>
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                        <div class="fxt-middle-content">
                            <div class="fxt-sub-title">Bienvenue chez les</div>
                            <h1 class="fxt-main-title">Jeunes Humanitaires.</h1>
                            <p class="fxt-description">
                            L' Association Jeunes Humanitaires est une Association Sans But Lucratif reunissant les jeunes qui font differentes contributions
                                dans le but d'apportez de l'aide aux personnes vulnerables. Nous aidons les personnes sans appuis, qui par manque de finance n'arrivent même pas à payer 
                                leurs factures à l'hôpital, scolariser ou nourrir leurs enfants mais aussi les personnes de 3ème age 
                                que l'on a longtemps oublié.
                            </p>
                        </div>
                    </div>
                    <div class="fxt-transformX-R-50 fxt-transition-delay-10">
                    </div>
                </div>
            </div>
            <div class="fxt-form-content">
                <div class="fxt-main-form">
                    <div class="fxt-inner-wrap fxt-opacity fxt-transition-delay-13">
                        <h2 class="fxt-page-title">Creez un compte</h2>
                        <p class="fxt-description">Creez-vous un compte pour connaitre nos incroyables services</p>
                        <form method="POST" action="">
                            <?php 
                                if(isset($error)){
                                    foreach($error as $error){
                                        echo '<span class="error-msg">'.$error.'</span>';
                                    };
                                };
                            ?>
                            <div class="form-group">
                                <label for="Nom" class="fxt-label">Nom d'utilisateur</label>
                                <input type="text" id="Nom" class="form-control" name="Nom" placeholder="Entrer votre nom d'utilisateur" required>
                            </div>
                            <div class="form-group">
                                <label for="MotDePasse" class="fxt-label">Mot de passe</label>
                                <input id="MotDePasse" type="password" class="form-control" name="MotDePasse" placeholder="Entrer le mot de passe" required>
                            </div>
                            <div class="form-group">
                                <label for="RefMbr" class="fxt-label">Code du membre</label>
                                <input id="RefMbr" type="text" class="form-control" name="RefMbr" placeholder="Entrer votre code" required>
                            </div>                           
                            <div class="form-group mb-3">
                                <button type="submit" name="submit" id="submit" class="fxt-btn-fill">Creer un compte</button>
                            </div>
                            <p>Vous avez un compte? <a href="./index.php">Cliquez ici pour vous connectez !</a></p>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jquery-->
    <script src="includes-login/js/jquery-3.5.0.min.js"></script>
    <!-- Bootstrap js -->
    <script src="includes-login/js/bootstrap.min.js"></script>
    <!-- Imagesloaded js -->
    <script src="includes-login/js/imagesloaded.pkgd.min.js"></script>
    <!-- Validator js -->
    <script src="includes-login/js/validator.min.js"></script>
    <!-- Custom Js -->
    <script src="includes-login/js/main.js"></script>

</body>


<!-- Mirrored from affixtheme.com/html/xmee/demo/login-33.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Jan 2022 18:24:17 GMT -->
</html>