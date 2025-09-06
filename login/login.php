<?php
session_start();
require_once '../bd/conbd.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connecter'])) {
    $username = $_POST['username'];
    $pswd = $_POST['pswd'];

    // Vérifie d'abord dans fournisseur
    $stmt = $con->prepare("SELECT idFourni,noms, username, pswd FROM fournisseur WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $fournisseur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fournisseur && $fournisseur['pswd'] === md5($pswd)) {
        $_SESSION['idFourni'] = $fournisseur['idFourni'];
        $_SESSION['username'] = $fournisseur['username'];
        $_SESSION['noms'] = $fournisseur['noms'];
        header('Location: ../fournisseur/indexFourni.php');
        exit;
    }
    // Sinon vérifie dans user
    $stmt2 = $con->prepare("SELECT idUser,username, pswd, niveauAcces FROM user WHERE username = ? LIMIT 1");
    $stmt2->execute([$username]);
    $user = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['pswd'] === md5($pswd)) {
        $_SESSION['idUser'] = $user['idUser'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['niveauAcces'] = $user['niveauAcces'];
        header('Location: ./../index.php');
        exit;
    }

    $alertClass = 'danger';
    $message = 'Nom d\'utilisateur ou mot de passe incorrect';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Appel d'offre - Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["../assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

</head>
<?php if ($message): ?>
    <div id="message" class="alert alert-<?= $alertClass ?> text-center">
        <?= $message ?>
    </div>
<?php endif; ?>

<body>

    <div class="main-panel container-fluid">
        <div class="container">
            <div class="page-inner">
                <!-- Formulaire de connexion -->
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">Appel d'offre</h3>
                                <h4 class="text-center">Connexion</h4>
                                <form method="POST" action="">
                                    <div class="form-group mb-3">
                                        <label for="username" class="form-label">Nom d'utilisateur</label>
                                        <input type="text" id="username" class="form-control" name="username" placeholder="Entrer votre nom d'utilisateur" required="required">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="pswd" class="form-label">Mot de passe</label>
                                        <input id="pswd" type="password" class="form-control" name="pswd" placeholder="Entrer le mot de passe" required="required">
                                    </div>

                                    <div class="form-group mb-3 text-center">
                                        <button type="submit" name="connecter" id="connecter" class="btn btn-primary btn-round mx-auto">Connexion</button>

                                    </div>
                                    <p>Vous n'avez pas un compte? <a href="./register.php">Cliquez ici pour créer un compte</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <div class="">© 2025 All rights reserved by Team 467</div>
                <div>Done by Team 467.</div>
            </div>
        </footer>
    </div>


    <!-- 3. Bootstrap et ses dépendances -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- 6. Kaiadmin JS (si nécessaire pour l’UI) -->
    <script src="../assets/js/kaiadmin.min.js"></script>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('message');
            if (msg) msg.style.display = 'none';
        }, 5000);
    </script>


</body>

</html>