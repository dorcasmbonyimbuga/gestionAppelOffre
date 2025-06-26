<?php include "bd/conbd.php";
session_start();
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
$idFourni=isset($_SESSION['idFourni']);
$initiales = implode('', array_map(function ($part) {
  return strtoupper($part[0]);
}, explode(' ', $nom)));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Appel d'offre - Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
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
        urls: ["assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />


</head>


<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.php" class="logo text-white">Appel Offre</a>
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
            <li class="nav-item active">
              <a
                href="index.php">
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

            <li class="nav-item">
              <a href="./pages/produit.php">
                <i class="fas fa-luggage-cart"></i>
                <p>Produits</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/fournisseur.php">
                <i class="fas fa-users"></i>
                <p>Fournisseurs</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#maps">
                <i class="fas fa-th-list"></i>
                <p>Etat de besoin</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="maps">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="./pages/etatBesoin.php">
                      <span class="sub-item">Etat de besoin</span>
                    </a>
                  </li>
                  <li>
                    <a href="./pages/detailEtat.php">
                      <span class="sub-item">Detail etat de besoin</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a href="./pages/appelOffre.php">
                <i class="fas fa-bullhorn"></i>
                <p>Appel d'offre</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/candidat.php">
                <i class="fas fa-user-friends"></i>
                <p>Candidatures</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/user.php">
                <i class="far fa-user-circle"></i>
                <p>Utilisateurs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./login/logout.php">
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
            <a href="index.php" class="logo text-white">Appel Offre</a>
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
                      <input
                        type="text"
                        placeholder="Search ..."
                        class="form-control" />
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

      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Gestion d'appel d'offre</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <a href="#" class="btn btn-secondary btn-round"><i class="fas fa-print"></i> Imprimer Etat de besoins</a>
            </div>
          </div>
          <!-- Debut section statistique -->
          <div class="row">
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fa-luggage-cart"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Produits</p>
                        <?php
                        try {
                          $stmt = $con->query("SELECT COUNT(*) as total FROM produit");
                          $result = $stmt->fetch(PDO::FETCH_ASSOC);
                          echo '<h4 class="card-title">' . $result['total'] . '</h4>';
                        } catch (PDOException $e) {
                          echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Fournisseurs</p>
                        <?php
                        try {
                          $stmt = $con->query("SELECT COUNT(*) as total FROM fournisseur");
                          $result = $stmt->fetch(PDO::FETCH_ASSOC);
                          echo '<h4 class="card-title">' . $result['total'] . '</h4>';
                        } catch (PDOException $e) {
                          echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="far fa-check-circle"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Appel d'offre</p>
                        <?php
                        try {
                          $stmt = $con->query("SELECT COUNT(*) as total FROM appelOffre");
                          $result = $stmt->fetch(PDO::FETCH_ASSOC);
                          echo '<h4 class="card-title">' . $result['total'] . '</h4>';
                        } catch (PDOException $e) {
                          echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div
                        class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Candidats</p>
                        <?php
                        try {
                          $stmt = $con->query("SELECT COUNT(*) as total FROM candidats");
                          $result = $stmt->fetch(PDO::FETCH_ASSOC);
                          echo '<h4 class="card-title">' . $result['total'] . '</h4>';
                        } catch (PDOException $e) {
                          echo "Erreur : " . $e->getMessage();
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Fin  section statistique -->

          <!-- Debut section liste de candidats  -->
          <div class="row">
            <!-- Liste de candidats -->
            <div class="col-md-12">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Liste des candidats</div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <!--  table des candidats -->
                    <table class="table align-items-center mb-0" id="table_candidats">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Ref. Offre</th>
                          <th scope="col">Noms candidat</th>
                          <th scope="col">Statut</th>
                          <th scope="col">Date</th>
                          <th scope="col">Autres</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Table candidats -->
                        <?php
                        $stmt = $con->query("SELECT idCandidat,appelOffre.objets, fournisseur.noms, statut, dateCandidature, autresDetails FROM candidats inner join fournisseur on candidats.refFournisseurCandidat=fournisseur.idFourni inner join appelOffre on candidats.refAppelOffre=appelOffre.idAppel ORDER BY idCandidat DESC");
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {
                          echo '<tr>';
                          foreach ($row as $col) {
                            echo '<td>' . htmlspecialchars($col) . '</td>';
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Fin section liste de candidat et appel d'offre -->

          <!-- Debut section liste de fournisseurs et etat de besoins -->
          <div class="row">
            <!-- Liste Etat de besoin -->
            <div class="col-md-8">
              <div class="card card-round">
                <div class="card-header">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Etat de besoin</div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <!-- Projects table -->
                    <table id="table_detailEtat" class="table align-items-center mb-0">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Etat besoin</th>
                          <th scope="col">Produit</th>
                          <th scope="col">PU</th>
                          <th scope="col">Quantite</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Table Etat de besoin -->
                        <?php
                        $stmt = $con->query("SELECT idDetail,etatBesoin.libelle,produit.designation, PU, Qte FROM detailEtat inner join etatBesoin on detailEtat.refEtatDetail=etatBesoin.idEtat inner join produit on detailEtat.refProduit=produit.idProduit ORDER BY idDetail DESC");
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {
                          echo '<tr>';
                          foreach ($row as $col) {
                            echo '<td>' . htmlspecialchars($col) . '</td>';
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Liste de fournisseurs -->
            <div class="col-md-4">
              <div class="card card-round">
                <div class="card-body">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Liste de fournisseurs</div>
                  </div>
                  <div class="card-list py-4">
                    <div class="item-list">

                      <div class="info-user ms-3">
                        <?php
                        $stmt = $con->query("SELECT noms, adresse, contact FROM fournisseur ORDER BY idFourni DESC LIMIT 5");
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($rows as $row) {
                          $noms = htmlspecialchars($row['noms']);
                          $adresse = htmlspecialchars($row['adresse']);
                          $contact = htmlspecialchars($row['contact']);

                          // Générer les initiales
                          $initiales = '';
                          foreach (explode(' ', $noms) as $part) {
                            $initiales .= strtoupper(substr($part, 0, 1));
                          }
                          echo '
                              <div class="d-flex align-items-center mb-3">
                                  <div class="avatar me-3">
                                      <span class="avatar-title rounded-circle border border-white bg-secondary text-white">'
                            . $initiales .
                            '</span>
                                  </div>
                                  <div>
                                      <div class="username fw-bold">' . $noms . '</div>
                                      <div class="status text-muted">' . $adresse . ' | ' . $contact . '</div>
                                  </div>
                              </div>';
                        }
                        ?>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Fin section liste de fournisseurs et etat de besoins -->
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">

          <div class="">
            © 2025 All rights reserved by Team 467
          </div>
          <div>
            Designed by Dorcas Mbonyimbuga.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Datatables -->
  <script src="assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- Sweet Alert -->
  <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="assets/js/kaiadmin.min.js"></script>


  <!-- Initialisation DataTables -->
  <script>
    $(document).ready(function() {
      $('#table_candidats').DataTable();
      $('#table_detailEtat').DataTable();
    });
  </script>

  <script>
    function chargerNotifications() {
      $.ajax({
        url: 'process/get_notifications.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          let html = '';
          if (data.length === 0) {
            html = '<div class="notif-center"><span class="dropdown-item">Aucune notification</span></div>';
          } else {
            html += '<div class="notif-center">';
            data.forEach(notif => {
              html += `
            <a href="#">
              <div class="notif-content">
                <span class="block">${notif.noms}</span>
                <span class="block">${notif.objets}</span>
                <span class="time">${notif.timeago}</span>
              </div>
            </a>`;
            });
            html += '</div>';
          }

          $('#notif-container').html(html);
          $('#notif-count').text(data.length);
        }
      });
    }

    setInterval(chargerNotifications, 15000);
    $(document).ready(chargerNotifications);
  </script>

</body>

</html>