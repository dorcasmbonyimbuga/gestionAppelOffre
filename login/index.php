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
    <div class="wrapper">

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="../index.php" class="logo text-white">Appel Offre</a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
            </div>

            <div class="container">
                <div class="page-inner">
                    <!-- Formulaire de connexion -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Liste d'appel d'offres</h4>
                                        <button
                                            class="btn btn-primary btn-round btn-add ms-auto" data-modal="modalAppelOffre">
                                            <i class="fa fa-plus"></i>
                                            Ajouter Appel Offre
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            id="table_appelOffre"
                                            class="display table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Etat besoin</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Objets</th>
                                                    <th scope="col">Autres</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Contenu chargé par AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
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
    </div>


    <!-- 3. Bootstrap et ses dépendances -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- 6. Kaiadmin JS (si nécessaire pour l’UI) -->
    <script src="../assets/js/kaiadmin.min.js"></script>

</body>

</html>