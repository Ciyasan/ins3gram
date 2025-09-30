<?php
echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px 0; font-family: monospace;'>";
echo "<strong>TESTS HELPER :</strong><br>";
echo "URL actuelle simple : " . build_filter_url() . "<br>";
echo "URL avec per_page=16 : " . build_filter_url(['per_page' => 16]) . "<br>";
echo "URL avec alcool=1 : " . build_filter_url(['alcool' => 1]) . "<br>";
echo "</div>";
?>
<?php
echo "per_page=8 actif ? " . (is_filter_active('per_page', 8) ? 'OUI' : 'NON') . "<br>";
echo "per_page=16 actif ? " . (is_filter_active('per_page', 16) ? 'OUI' : 'NON') . "<br>";
echo "per_page=24 actif ? " . (is_filter_active('per_page', 24) ? 'OUI' : 'NON') . "<br>";
?>

<div style="background: #ffe6e6; padding: 10px; margin: 10px 0;">
    <strong>DEBUG :</strong><br>
    $_GET actuel : <?= print_r($_GET, true) ?><br>
    Page actuelle : <?= get_current_filter_value('page', 1) ?><br>
    Per_page actuel : <?= get_current_filter_value('per_page', 8) ?><br>
    Alcool actif : <?= is_filter_active('alcool', 1) ? 'OUI' : 'NON' ?>
</div>



<div class="row">
    <div class="col text-center">
        <h1>Liste des recettes</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="d-flex align-items-end">
            <span>Trier par </span>
            <select class="form-select">
                <option>Nom (ASC)</option>
            </select>

            <?php echo form_open('recettes', ['method' => 'get']); ?>

            <div class="btn-group">
                <div class="btn-group">
                    <a href="<?= build_filter_url(['per_page' => 8]) ?>"
                        class="btn <?= is_filter_active('per_page', 8) ? 'btn-primary' : 'btn-secondary' ?>">8</a>
                    <a href="<?= build_filter_url(['per_page' => 16]) ?>"
                        class="btn <?= is_filter_active('per_page', 16) ? 'btn-primary' : 'btn-secondary' ?>">16</a>
                    <a href="<?= build_filter_url(['per_page' => 24]) ?>"
                        class="btn <?= is_filter_active('per_page', 24) ? 'btn-primary' : 'btn-secondary' ?>">24</a>
                </div>


            </div>

            <?php echo form_close(); ?>


        </div>
    </div>
</div>
<!--START: PAGE -->
<div class="row">
    <!--START: FILTRE -->
    <div class="col-md-2 ">
        <span class="h3">FILTRES</span>
        <?php echo form_open(build_filter_url(), ['method' => 'get']); ?>
        <div class="form-check">
            <input type="checkbox" name="alcool" value="1" class="form-check-input" id="alcool"
                <?= is_filter_active('alcool', 1) ? 'checked' : '' ?>>

            <label class="form-check-label" for="alcool">Avec alcool</label>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <?php echo form_close(); ?>
        <!-- Option 2 : Avec remove_filter_url -->
        <a href="<?= remove_filter_url(['alcool', 'per_page', 'page']) ?>" class="btn btn-outline-secondary">Réinitialiser</a>
    </div>
    <!--END: FILTRE -->
    <!--START: CONTENUS -->
    <div class="col p-4">
        <!--START: RECETTES -->
        <div class="row row-cols-2 row-cols-md-4 all-recipes">
            <?php foreach ($recipes as $recipe): ?>
                <div class="col mb-4">
                    <div class="card ls-recipe h-100">
                        <a href="<?= base_url('recette/' . $recipe['slug']); ?>"> <img class="card-img-top img-fluid" src="<?= base_url($recipe['mea']); ?>"></a>
                        <div class="card-body">
                            <div class="card-title h5">
                                <?= $recipe['name']; ?>
                            </div>
                            <div class="mb-2" style="color: var(--bs-yellow);">
                                <?php for ($i = 0; $i < 5; $i++) {
                                    if ($i < $recipe['score']) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                } ?>
                            </div>
                            <div class="d-grid">
                                <a href="<?= base_url('recette/' . $recipe['slug']); ?>" class="btn btn-primary"><i class="fas fa-eye"></i> Voir la recette</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--END: RECETTES -->
        <!--START: PAGINATION -->
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <?php if ($pager): ?>
                                <div class="d-flex justify-content-center">
                                    <?= $pager->links('default', 'bootstrap_full') ?>
                                </div>
                            <?php endif; ?>

                            <!-- <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a href="<?= get_pagination_url($current_page - 1) ?>" class="page-link">Previous</a>
                                </li>
                            <?php endif; ?>
                            <li class="page-item <?= $current_page == 1 ? 'active' : '' ?>">
                                <a class="page-link" href="<?= get_pagination_url(1) ?>">1</a>
                            </li>
                            <li class="page-item <?= $current_page == 2 ? 'active' : '' ?>">
                                <a class="page-link" href="<?= get_pagination_url(2) ?>">2</a>
                            </li>
                            <li class="page-item <?= $current_page == 3 ? 'active' : '' ?>">
                                <a class="page-link" href="<?= get_pagination_url(3) ?>">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?= get_pagination_url($current_page + 1) ?>">Next</a>
                            </li>
                        </ul> -->

                    </nav>
                </div>
            </div>
        </div>
        <!--END: PAGINATION -->
    </div>
    <!--END: CONTENUS -->
</div>
<!--END: PAGE -->