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
                                <h4 class="text-center">Login</h4>
                                <form method="POST" action="./login.php">
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
                <div>Done by Dorcas Mbonyimbuga.</div>
            </div>
        </footer>
    </div>


    <!-- 3. Bootstrap et ses dépendances -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- 6. Kaiadmin JS (si nécessaire pour l’UI) -->
    <script src="../assets/js/kaiadmin.min.js"></script>

</body>

</html>