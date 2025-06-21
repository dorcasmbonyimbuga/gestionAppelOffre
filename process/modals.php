<!-- Modal Fournisseur -->
<div class="modal fade" id="modalFournisseur" tabindex="-1" aria-labelledby="modalFournisseurLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formFournisseur">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFournisseurLabel">Ajouter / Modifier Fournisseur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="fournisseur">
          <input type="hidden" name="idFourni" id="idFourni">

          <div class="mb-3">
            <label for="noms" class="form-label">Nom</label>
            <input type="text" class="form-control" name="noms" id="noms" required>
          </div>

          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="adresse" id="adresse">
          </div>

          <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" name="contact" id="contact">
          </div>

          <div class="mb-3">
            <label for="autres" class="form-label">Autres infos</label>
            <input type="text" class="form-control" name="autres" id="autres">
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="username" id="username" required>
          </div>

          <div class="mb-3">
            <label for="pswd" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="pswd" id="pswd" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Etat de Besoin -->
<div class="modal fade" id="modalEtatBesoin" tabindex="-1" aria-labelledby="modalEtatBesoinLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEtatBesoin">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEtatBesoinLabel">Ajouter / Modifier État de Besoin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="etatBesoin">
          <input type="hidden" name="idEta" id="idEta">

          <div class="mb-3">
            <label for="refFournisseur" class="form-label">Fournisseur (Réf)</label>
            <input type="text" class="form-control" name="refFournisseur" id="refFournisseur" required>
          </div>

          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
          </div>

          <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input type="text" class="form-control" name="libelle" id="libelle" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Catégorie Produit -->
<div class="modal fade" id="modalCategorieProduit" tabindex="-1" aria-labelledby="modalCategorieProduitLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCategorieProduit">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCategorieProduitLabel">Ajouter / Modifier Catégorie de Produit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="categorieProduit">
          <input type="hidden" name="idCategorie" id="idCategorie">

          <div class="mb-3">
            <label for="designation" class="form-label">Désignation</label>
            <input type="text" class="form-control" name="designation" id="designation" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Produit -->
<div class="modal fade" id="modalProduit" tabindex="-1" aria-labelledby="modalProduitLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProduit">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProduitLabel">Ajouter / Modifier Produit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="produit">
          <input type="hidden" name="idProduit" id="idProduit">

          <div class="mb-3">
            <label for="designation" class="form-label">Désignation</label>
            <input type="text" class="form-control" name="designation" id="designation" required>
          </div>

          <div class="mb-3">
            <label for="PU" class="form-label">Prix Unitaire</label>
            <input type="number" step="0.01" class="form-control" name="PU" id="PU" required>
          </div>

          <div class="mb-3">
            <label for="unite" class="form-label">Unité</label>
            <input type="text" class="form-control" name="unite" id="unite" required>
          </div>

          <div class="mb-3">
            <label for="refCategorie" class="form-label">Catégorie</label>
            <select name="refCategorie" id="refCategorie" class="form-select" required>
              <option value="">-- Sélectionner une catégorie --</option>
              <!-- À remplir dynamiquement en JS si besoin -->
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Détail État de Besoin -->
<div class="modal fade" id="modalDetailEtat" tabindex="-1" aria-labelledby="modalDetailEtatLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formDetailEtat">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailEtatLabel">Ajouter / Modifier Détail État de Besoin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="detailEtat">
          <input type="hidden" name="idDetail" id="idDetail">

          <div class="mb-3">
            <label for="refEtat" class="form-label">Réf. État de Besoin</label>
            <input type="text" class="form-control" name="refEtat" id="refEtat" required>
          </div>

          <div class="mb-3">
            <label for="refProduit" class="form-label">Réf. Produit</label>
            <input type="text" class="form-control" name="refProduit" id="refProduit" required>
          </div>

          <div class="mb-3">
            <label for="PU" class="form-label">Prix Unitaire</label>
            <input type="number" step="0.01" class="form-control" name="PU" id="PU" required>
          </div>

          <div class="mb-3">
            <label for="Qte" class="form-label">Quantité</label>
            <input type="number" class="form-control" name="Qte" id="Qte" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Appel d'Offre -->
<div class="modal fade" id="modalAppelOffre" tabindex="-1" aria-labelledby="modalAppelOffreLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAppelOffre">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAppelOffreLabel">Ajouter / Modifier Appel d'Offre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="appelOffre">
          <input type="hidden" name="idAppel" id="idAppel">

          <div class="mb-3">
            <label for="refEtat" class="form-label">Réf. État de Besoin</label>
            <input type="text" class="form-control" name="refEtat" id="refEtat" required>
          </div>

          <div class="mb-3">
            <label for="date" class="form-label">Date de l'appel</label>
            <input type="date" class="form-control" name="date" id="date" required>
          </div>

          <div class="mb-3">
            <label for="objets" class="form-label">Objet</label>
            <input type="text" class="form-control" name="objets" id="objets" required>
          </div>

          <div class="mb-3">
            <label for="autres" class="form-label">Autres informations</label>
            <textarea class="form-control" name="autres" id="autres" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Candidats -->
<div class="modal fade" id="modalCandidats" tabindex="-1" aria-labelledby="modalCandidatsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCandidats">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCandidatsLabel">Ajouter / Modifier un Candidat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Champs cachés -->
          <input type="hidden" name="table" value="candidats">
          <input type="hidden" name="idCandidat" id="idCandidat">

          <div class="mb-3">
            <label for="refAppel" class="form-label">Réf. Appel d'Offre</label>
            <input type="text" class="form-control" name="refAppel" id="refAppel" required>
          </div>

          <div class="mb-3">
            <label for="refFournisseur" class="form-label">Réf. Fournisseur</label>
            <input type="text" class="form-control" name="refFournisseur" id="refFournisseur" required>
          </div>

          <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <input type="text" class="form-control" name="statut" id="statut">
          </div>

          <div class="mb-3">
            <label for="date" class="form-label">Date de candidature</label>
            <input type="date" class="form-control" name="date" id="date">
          </div>

          <div class="mb-3">
            <label for="autre" class="form-label">Autres infos</label>
            <textarea class="form-control" name="autre" id="autre" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
