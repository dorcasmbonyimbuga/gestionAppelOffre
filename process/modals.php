<!-- Connexion vers la BD -->
 <?php require_once './../bd/conbd.php';?>
<!-- Modal Fournisseur -->
<div class="modal fade" id="modalFournisseur" tabindex="-1" aria-labelledby="modalFournisseurLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formFournisseur" name="formFournisseur">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalFournisseurLabel">Ajouter / Modifier Fournisseur</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="fournisseur">
                    <input type="hidden" name="idFourni" id="idFourni">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Etat de Besoin -->
<div class="modal fade" id="modalEtatBesoin" tabindex="-1" aria-labelledby="modalEtatBesoinLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formEtatBesoin" name="formEtatBesoin">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalEtatBesoinLabel">Ajouter / Modifier État de Besoin</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="etatBesoin">
                    <input type="hidden" name="idEtat" id="idEtat">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="refFournisseurEtat" class="form-label">Fournisseur (Réf)</label>
                            <select name="refFournisseurEtat" id="refFournisseurEtat" class="form-select" required>
                                <option value="">-- Sélectionner un fournisseur --</option>
                                <?php
                                $sql = "SELECT * FROM fournisseur";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idFourni'] . ">" . $reponse['noms'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="libelle" class="form-label">Libellé</label>
                            <input type="text" class="form-control" name="libelle" id="libelle" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Catégorie Produit -->
<div class="modal fade" id="modalCategorieProduit" tabindex="-1" aria-labelledby="modalCategorieProduitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formCategorieProduit" name="formCategorieProduit">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategorieProduitLabel">Ajouter / Modifier Catégorie de Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="categorieProduit">
                    <input type="hidden" name="idCategorie" id="idCategorie">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="designationCat" class="form-label">Désignation</label>
                            <input type="text" class="form-control" name="designationCat" id="designationCat" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Produit -->
<div class="modal fade" id="modalProduit" tabindex="-1" aria-labelledby="modalProduitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formProduit" name="formProduit">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProduitLabel">Ajouter / Modifier Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="produit">
                    <input type="hidden" name="idProduit" id="idProduit">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="designation" class="form-label">Désignation</label>
                            <input type="text" class="form-control" name="designation" id="designation" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="PUProduit" class="form-label">Prix Unitaire</label>
                            <input type="number" step="0.01" class="form-control" name="PUProduit" id="PUProduit" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="unite" class="form-label">Unité</label>
                            <input type="text" class="form-control" name="unite" id="unite" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="refCategorie" class="form-label">Catégorie</label>
                            <select name="refCategorie" id="refCategorie" class="form-select" required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                <?php
                                $sql = "SELECT * FROM categorieProduit";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idCategorie'] . ">" . $reponse['designationCat'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Détail État de Besoin -->
<div class="modal fade" id="modalDetailEtat" tabindex="-1" aria-labelledby="modalDetailEtatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formDetailEtat" name="formDetailEtat">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailEtatLabel">Ajouter / Modifier Détail État de Besoin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="detailEtat">
                    <input type="hidden" name="idDetail" id="idDetail">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="refEtatDetail" class="form-label">Réf. État de Besoin</label>
                            <select name="refEtatDetail" id="refEtatDetail" class="form-select" required>
                                <option value="">-- Sélectionner libellé Etat de besoin --</option>
                                <?php
                                $sql = "SELECT * FROM etatBesoin";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idEtat'] . ">" . $reponse['libelle'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="refProduit" class="form-label">Réf. Produit</label>
                            <select name="refProduit" id="refProduit" class="form-select" required>
                                <option value="">-- Sélectionner le produit --</option>
                                <?php
                                $sql = "SELECT * FROM produit";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idProduit'] . ">" . $reponse['designation'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="PU" class="form-label">Prix Unitaire</label>
                            <input type="number" step="0.01" class="form-control" name="PU" id="PU" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="Qte" class="form-label">Quantité</label>
                            <input type="number" class="form-control" name="Qte" id="Qte" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Appel d'Offre -->
<div class="modal fade" id="modalAppelOffre" tabindex="-1" aria-labelledby="modalAppelOffreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formAppelOffre" name="formAppelOffre">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAppelOffreLabel">Ajouter / Modifier Appel d'Offre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="appelOffre">
                    <input type="hidden" name="idAppel" id="idAppel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="refEtatAppel" class="form-label">Réf. État de Besoin</label>
                            <select name="refEtatAppel" id="refEtatAppel" class="form-select" required>
                                <option value="">-- Sélectionner libellé Etat de besoin --</option>
                                <?php
                                $sql = "SELECT * FROM etatBesoin";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idEtat'] . ">" . $reponse['libelle'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="datePub" class="form-label">Date de l'appel</label>
                            <input type="date" class="form-control" name="datePub" id="datePub" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="objets" class="form-label">Objet</label>
                            <input type="text" class="form-control" name="objets" id="objets" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="autresInfo" class="form-label">Autres informations</label>
                            <textarea class="form-control" name="autresInfo" id="autresInfo" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Candidats -->
<div class="modal fade" id="modalCandidats" tabindex="-1" aria-labelledby="modalCandidatsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formCandidats" name="formCandidats">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCandidatsLabel">Ajouter / Modifier un Candidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="candidats">
                    <input type="hidden" name="idCandidat" id="idCandidat">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="refAppelOffre" class="form-label">Réf. Appel d'Offre</label>
                            <select name="refAppelOffre" id="refAppelOffre" class="form-select" required>
                                <option value="">-- Sélectionner  l'objet de l'appel --</option>
                                <?php
                                $sql = "SELECT * FROM appelOffre";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idAppel'] . ">" . $reponse['objets'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="refFournisseurCandidat" class="form-label">Réf. Fournisseur</label>
                            <select name="refFournisseurCandidat" id="refFournisseurCandidat" class="form-select" required>
                                <option value="">-- Sélectionner un fournisseur --</option>
                                <?php
                                $sql = "SELECT * FROM fournisseur";
                                $stmt = $con->prepare($sql);
                                $stmt->execute();

                                while ($reponse = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $reponse['idFourni'] . ">" . $reponse['noms'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select" required>
                                <option value="">-- Sélectionner le statut --</option>
                                <option value="">En attente</option>
                                <option value="Reçu">Reçu</option>
                                <option value="Validé">Validé</option>
                            </select>
                            <!-- <input type="text" class="form-control" name="statut" id="statut"> -->
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="dateCandidature" class="form-label">Date de candidature</label>
                            <input type="date" class="form-control" name="dateCandidature" id="dateCandidature">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="autresDetails" class="form-label">Autres infos</label>
                            <textarea class="form-control" name="autresDetails" id="autresDetails" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formUser" name="formUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserLabel">Ajouter / Modifier Appel d'Offre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs cachés -->
                    <input type="hidden" name="table" value="user">
                    <input type="hidden" name="idUser" id="idUser">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" name="username" id="datePub" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pswd" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="pswd" id="pswd" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="niveauAcces" class="form-label">Niveau d'accès</label>
                            <input type="text" class="form-control" name="niveauAcces" id="niveauAcces" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>