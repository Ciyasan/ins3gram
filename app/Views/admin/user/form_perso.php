<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <?php if (isset($user)) : ?>
          <!-- MODE MODIFICATION : affiche le pseudo de l'utilisateur -->
          <h1>Modification de <?= $user->username; ?></h1>
        <?php else : ?>
          <!-- MODE CRÉATION : titre générique -->
          <h1>Création d'un nouvel utilisateur</h1>
        <?php endif; ?>
      </div>
      <?php
      // Ouverture du formulaire selon le cas : update ou create
      if (isset($user)):
        echo form_open('admin/user/update', ['class' => 'needs-validation', 'novalidate' => true]); ?>
        <!-- Champ caché pour stocker l'ID de l'utilisateur lors de la modification -->
        <input type="hidden" name="id" value="<?= $user->id ?>">
      <?php
      else:
        echo form_open('admin/user/create', ['class' => 'needs-validation', 'novalidate' => true]);
      endif;
      ?>

      <div class="card-body">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur" value="<?= isset($user->username) ? $user->username : '' ?>" required>
              <label for="username">Nom d'utilisateur</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" <?= !isset($user->id) ? 'required' : '' ?>>
              <label for="password">Mot de passe</label>
            </div>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= isset($user->email) ? $user->email : '' ?>" required>
              <label for="email">Email</label>
            </div>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Prénom" value="<?= isset($user->first_name) ? $user->first_name : '' ?>">
              <label for="first_name">Prénom</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nom" value="<?= isset($user->last_name) ? $user->last_name : '' ?>">
              <label for="last_name">Nom</label>
            </div>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= isset($user->birthdate) ? date('Y-m-d', strtotime($user->birthdate)) : set_value('birthdate') ?>" required>
              <label for="birthdate">Date de naissance</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <select class="form-select" name="id_permission" id="id_permission">
                <?php foreach ($permissions as $perm) : ?>
                  <!-- Création d'une option pour chaque permission -->
                  <option value="<?= $perm['id']; ?>"
                    <?= (isset($user->id_permission) && ($user->id_permission == $perm['id'])) ? 'selected' : ''; ?>>
                    <?= $perm['name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <label for="id_permission">Permission</label>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="text-end">
            <!-- BOUTON DE SOUMISSION -->
            <!-- La valeur change selon le mode (créer/modifier) -->
            <input class="btn btn-primary" type="submit"
              value="<?= (isset($user->id) ? "modifier" : "creer"); ?>">
          </div>

        </div>
      </div>

    </div>
  </div>