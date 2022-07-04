<?php
    ob_start();
    $film = $stmtFilms->fetch();
?>

<h1 class="mb-5 mt-5">Modifier <?= $film['titre_film']?></h1>

<div class="container mb-5">
    <div class="row row-col-4 g-3 ">
        <form action="index.php?action=modifierFilm&id=<?=$film['id_film']?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-5 col-4 ">
                    <label for="formGroupExampleInput" class="form-label">Titre film</label>
                    <input name="titre_film" type="text" class="form-control" id="formGroupExampleInput" value ="<?= $film['titre_film']?>">
                </div>    
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput2" class="form-label">Date de sortie</label>
                    <input name="annee_sortie" type="date" class="form-control" id="formGroupExamplput2"  value="<?=$film['annee_sortie']?>" >
                </div>
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput3" class="form-label">durée en minutes</label>
                    <input name="duree_min" type="int" class="form-control" id="formGroupExampleInput3"  value="<?=$film['duree_min'] ?>">
                </div>
            </div>
            <div class="mb-5">
                <label for="exampleFormControlTextarea1" class="form-label">Synopsis</label>
                <textarea name="synopsis" class="form-control" id="exampleFormControlTextarea1" rows="3"><?=$film['synopsis'] ?></textarea>
            </div>
            <div class="row d-flex justify-content-evenly">
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput4" class="form-label">Note du film</label>
                    <input name="note" type="float" class="form-control" id="formGroupExampleInput4" value="<?=$film['note'] ?>">
                </div>
                <div class="mb-5 col-4">
                    <label for="formFile" class="form-label">Choisis l'affiche du film</label>
                    <input name="affiche"  type="file" class="form-control" id="formFile">
                </div>
            </div>
            <div class="row d-flex justify-content-evenly">
                <select name="id_realisateur" class="form-select form-select-lg mb-3 col-4" aria-label=".form-select-lg example" required>
                    <option >Sélectionne un réalisateur</option>
                        <?php foreach ($listRealisateur->fetchAll() as $realisateur) : ?>
                    <option  value="<?=$realisateur['id_realisateur']?>"><?=$realisateur['realisateur']?></option>
                        <?php endforeach; ?> 
                </select>
            </div>
            <div class="row d-flex justify-content-evenly">
                <h2 class="mt-5 mb-4 text-center">Choisis une catégorie a ajouter au film</h2>
                <div class="col-3 mb-5">
                    <?php foreach ($requestSelection ->fetchAll() as $genre) : ?>
                        <div class="form-check ">
                            <!-- on récupere les id des genres dans un tableau -->
                            <input name="genre_id[]" class="form-check-input" type="checkbox" value="<?=$id=$genre['genre_id']?>" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                            <?=$genre['libelle']?>
                            </label></br>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex justify-content-evenly">
                <button class="btn btn-primary mb-5 " name="submit" type="submit">Modifier</button>
            </div>        
        </form>
    </div>
</div>
<?php

$contenu = ob_get_clean();
$title = "modifier film";
require "views/template.php";