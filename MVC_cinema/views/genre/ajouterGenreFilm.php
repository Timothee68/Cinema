<?php 
    ob_start();
?>

<h1 class="mb-5 mt-5">Rajouter une catégorie à un film</h1>

<div class="container">
    <div class="row">
        <form action="index.php?action=ajouterGenreFilm" method="post">
            <div class="row">
                <select name="film_id" class="form-select mt-5" aria-label="Default select example">
                        <option selected>Choisis un film</option>
                    <?php foreach($sqlRequeteFilm as $film) : ?>
                        <option value="<?= $film['id_film']?>"><?= $film['titre_film']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="row d-flex justify-content-evenly">
                <h2 class="mt-5 mb-5 text-center">Choisis une catégorie a ajouter</h2>
                <div class="col-5">
                    <?php foreach ($requestSelection ->fetchAll() as $genre) : ?>
                    <div class="form-check ">
                        <!-- on récupere les id des genres dans un tableau -->
                        <input name="genre_id[]" class="form-check-input" type="checkbox" value="<?=$id=$genre['genre_id']?>" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            <?=$genre['libelle']?>
                        </label></br>
                    </div>
                    <?php  endforeach; ?> 
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-evenly">
                <button class="btn btn-primary mb-5 " name="submit" type="submit">Ajouter</button>
            </div>    
        </form> 
    </div>
</div>

<?php
     $contenu = ob_get_clean() ;
     $title = "ajouter genre film";
     require "./views/template.php";
?>


