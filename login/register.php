<?php
require_once '../bd/conbd.php';

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enregistrer'])) {
    $noms = $_POST['noms'];
    $adresse = $_POST['adresse'];
    $contact = $_POST['contact'];
    $autres = $_POST['autres'];
    $username = $_POST['username'];
    $pswd = md5($_POST['pswd']); // Tu peux faire password_hash() ici si tu veux

    $stmt = $con->prepare("INSERT INTO fournisseur (noms, adresse, contact, autres, username, pswd) VALUES (?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$noms, $adresse, $contact, $autres, $username, $pswd]);

    if ($success) {
        $alertClass = 'success';
        $message = 'Inscription réussie ! Redirection en cours...';
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 2000);
              </script>";
    } else {
        $alertClass = 'danger';
        $message = 'Erreur lors de l\'inscription.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Appel d'offre - Register</title>
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

<body>
    <div class="main-panel container-fluid">
        <div class="container">
            <div class="page-inner">
                <!-- Formulaire de connexion -->
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">Création d'un compte fournisseur</h3>
                                <!-- <h4 class="text-center">Register</h4> -->
                                <form method="POST">
                                    <?php if ($message): ?>
                                        <div id="message" class="alert alert-<?= $alertClass ?> text-center">
                                            <?= $message ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="noms" class="form-label">Nom</label>
                                            <input type="text" class="form-control" name="noms" id="noms" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="adresse" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" name="adresse" id="adresse">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" name="contact" id="contact">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="autres" class="form-label">Autres infos</label>
                                            <input type="text" class="form-control" name="autres" id="autres">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">Nom d'utilisateur</label>
                                            <input type="text" class="form-control" name="username" id="username" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="pswd" class="form-label">Mot de passe</label>
                                            <input type="password" class="form-control" name="pswd" id="pswd" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 text-center">
                                        <button type="submit" name="enregistrer" id="enregistrer" class="btn btn-primary btn-round mx-auto">Enregistrer</button>

                                    </div>
                                    <p>Vous avez un compte? <a href="./login.php">Cliquez ici pour vous connecter</a></p>
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