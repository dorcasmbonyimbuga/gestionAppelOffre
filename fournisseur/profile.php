<?php
$pageTitle = "Mon Profile";
$currentPage = "profile";
$breadcrumb = ["Pages", "Mon Profile"];

include "../partials/headerFourni.php";

$id = $_SESSION['idFourni'];

$stmt = $con->prepare("SELECT * FROM fournisseur WHERE idFourni = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Mon Profil</h4>
                </div>
            </div>
            <div class="card-body">

                <div id="result-message"></div>
                <div class="row">
                    <!-- Modifier les infos personnelles -->
                    <form id="form-infos" class="mb-4 col-md-4">
                        <input type="hidden" name="action" value="update_infos">
                        <div class="mb-3">
                            <label>Nom complet</label>
                            <input type="text" name="noms" value="<?= htmlspecialchars($user['noms']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Adresse</label>
                            <input type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Contact</label>
                            <input type="text" name="contact" value="<?= htmlspecialchars($user['contact']) ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Autres infos</label>
                            <textarea name="autres" class="form-control"><?= htmlspecialchars($user['autres']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Mettre à jour les infos</button>
                    </form>

                    <!-- Changer le nom d'utilisateur -->
                    <form id="form-username" class="mb-4 col-md-4">
                        <input type="hidden" name="action" value="update_username">
                        <div class="mb-3">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="newUsername" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Changer de nom d'utilisateur</button>
                    </form>

                    <!-- Changer le mot de passe -->
                    <form id="form-password" class="mb-4 col-md-4">
                        <input type="hidden" name="action" value="update_password">
                        <div class="mb-3">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="newPassword" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Changer le mot de passe</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../partials/footerFourni.php"; ?>
<script>
    $(document).ready(function() {
        function afficherMessage(message, type = 'success') {
            $('#result-message').html(`<div class="alert alert-${type}">${message}</div>`);
            setTimeout(() => $('#result-message').html(''), 4000);
        }

        // Modifier infos personnelles
        $('#form-infos').on('submit', function(e) {
            e.preventDefault();
            $.post('../process/updateProfile.php', $(this).serialize(), function(response) {
                afficherMessage("Informations mises à jour !");
                $('.profile-username .fw-bold').text($('input[name="noms"]').val());
            });
        });

        // Modifier username
        $('#form-username').on('submit', function(e) {
            e.preventDefault();
            $.post('../process/updateProfile.php', $(this).serialize(), function(response) {
                afficherMessage("Nom d'utilisateur mis à jour !");
                $('.profile-username .fw-bold').text($('input[name="newUsername"]').val());
            });
        });

        // Modifier mot de passe
        $('#form-password').on('submit', function(e) {
            e.preventDefault();
            $.post('../process/updateProfile.php', $(this).serialize(), function(response) {
                afficherMessage("Mot de passe modifié !");
            });
        });
    });
</script>