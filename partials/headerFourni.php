<?php
require '../bd/conbd.php';
include '../login/auth.php';
$message = '';
$alertClass = '';
?>
<!-- Dans votre HTML -->
<?php if ($message): ?>
    <div id="message" class="alert alert-<?= $alertClass ?> text-center">
        <?= $message ?>
    </div>
<?php endif; ?>

<script>
    setTimeout(() => {
        const msg = document.getElementById('message');
        if (msg) msg.style.display = 'none';
    }, 5000);
</script>

<!-- Affichage dans le menu topbar -->
<?php
$nom = isset($_SESSION['noms']) ? $_SESSION['noms'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Invité');

$initiales = implode('', array_map(function ($part) {
    return strtoupper($part[0]);
}, explode(' ', $nom)));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Appel d'offre - <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></title>
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
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="indexFourni.php" class="logo text-white">Appel Offre</a>
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
            <!-- Debut Menu du sidbar -->
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item <?= ($currentPage === 'indexFourni') ? 'active' : '' ?>">
                            <a href="indexFourni.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Pages</h4>
                        </li>

                        <li class="nav-item <?= ($currentPage === 'listeAppel') ? 'active' : '' ?>">
                            <a href="listeAppel.php">
                                <i class="fas fa-bullhorn"></i>
                                <p>Liste Appel</p>
                            </a>
                        </li>

                        <li class="nav-item <?= ($currentPage === 'mesCandidatures') ? 'active' : '' ?>">
                            <a href="mesCandidatures.php">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Mes candidatures</p>
                            </a>
                        </li>
                        <li class="nav-item <?= ($currentPage === 'profile') ? 'active' : '' ?>">
                            <a href="profile.php">
                                <i class="far fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../login/logout.php">
                                <i class="fas fa-arrow-circle-left"></i>
                                <p>Déconnexion</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Debut Menu du sidbar -->
        <!-- End Sidebar -->

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
                <!-- Navbar Header -->
                <nav
                    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input
                                    type="text"
                                    placeholder="Search ..."
                                    class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li
                                class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a
                                    class="nav-link dropdown-toggle"
                                    data-bs-toggle="dropdown"
                                    href="#"
                                    role="button"
                                    aria-expanded="false"
                                    aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="notifDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="notification" id="notif-count">0</span>
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">Vous avez <span id="notif-count">0</span> notification(s)</div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer" id="notif-container">
                                            <!-- notifications chargées ici -->
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="profile-pic" href="#">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle border border-white bg-secondary">
                                            <?= $initiales ?>
                                        </span>
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Bonjour,</span>
                                        <span class="fw-bold"><?= htmlspecialchars($nom) ?></span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
            <!-- PAGE HEADER DYNAMIQUE -->
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3"><?= htmlspecialchars($pageTitle ?? 'Titre') ?></h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <?php if (isset($breadcrumb)) : ?>
                                <?php foreach ($breadcrumb as $index => $item): ?>
                                    <li class="nav-item">
                                        <a href="#"><?= htmlspecialchars($item) ?></a>
                                    </li>
                                    <?php if ($index < count($breadcrumb) - 1): ?>
                                        <li class="separator">
                                            <i class="icon-arrow-right"></i>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>