<?php 
    ob_start();
?>
<div class="container">
    <h1 class="mb-5">Les Films par Catégories</h1>
        <div class="row">
            <div class="d-flex justify-content-evenly">
                <div class="dropdown col-3 d-flex justify-content-evenly">
                    <button class="btn btn-primary text-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Editer genre
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <button type="button" class="btn btn-lg  "><a href="index.php?action=ajouterGenre">Ajouter une catégorie</a></button>
                        <button type="button" class="btn btn-lg  "><a href="index.php?action=modifierGenre">Modifier une catégorie</a></button>
                        <button type="button" class="btn btn-lg  "><a href="index.php?action=deletGenre">Supprimer une catégorie</a></button>
                        <button type="button" class="btn btn-lg  "><a href="index.php?action=ajouterGenreFilm">Ajouter catégorie à un film</a></button>
                    </ul>
                </div>
            </div>
            <div class="row row-cols-md-4 g-4 mt-5 d-flex justify-content-evenly">
                <?php foreach ($genres->fetchAll() as $genre) : ?>
                    <div class="card m-2 bg-dark">
                        <div class="card-body text-center bg-dark">
                            <h5><a href="index.php?action=detailGenre&id=<?= $genre['id_genre']?>"><?= $genre['libelle'] ?></a></h5>
                            <h5><?= $genre['nb_film_par_genre'] ?> <strong>film(s)</strong></h5> 
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>    
</div>

<?php
    $contenu = ob_get_clean();
    $title = "classement par genre";
    require "./views/template.php";
    