<?php
    ob_start();
?>

<h1 class="mb-5 mt-5">Ajouter un film</h1>

<div class="container mb-5">
    <div class="row g-0">
        <form action="index.php?action=ajouterFilm" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput" class="form-label">Titre film</label>
                    <input name="titre_film" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
                </div>
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput2" class="form-label">Date de sortit</label>
                    <input name="annee_sortie" type="date" class="form-control" id="formGroupExampleInput2" placeholder="Example input placeholder">
                </div>
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput3" class="form-label">durée en minutes</label>
                    <input name="duree_min" type="int" class="form-control" id="formGroupExampleInput3" placeholder="Example input placeholder" required="required">
                </div>
            </div>
            <div class="mb-5 col-12">
                <label for="exampleFormControlTextarea1" class="form-label">Synopsis</label>
                <textarea name="synopsis" class="form-control" id="exampleFormControlTextarea1" rows="3" required="required"></textarea>
            </div>
            <div class="row d-flex justify-content-evenly">
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput4" class="form-label">Note du film</label>
                    <input name="note" type="float" class="form-control" id="formGroupExampleInput4" placeholder="Example input placeholder" required="required">
                </div>
                <div class="mb-5 col-4">
                    <label for="formFile" class="form-label">Choisis l'affiche du film</label>
                    <input name="affiche" type="file" class="form-control" id="formFile">
                </div>
            </div>
            <div class="row d-flex justify-content-evenly">
                <select name="realisateur_id" class="form-select form-select-lg mb-3 col-4" aria-label=".form-select-lg example" required="required">
                    <option>Sélectionne un réalisateur</option>
                        <?php   foreach ($listRealisateur->fetchAll() as $realisateur) : ?>
                            <option value="<?=$id=$realisateur['id_realisateur']?>"><?=$realisateur['realisateur']?></option>
                        <?php endforeach; ?> 
                </select>
            </div>
        <div class="row d-flex justify-content-evenly">    
            <h2 class="mt-5 mb-4 text-center">Choisis une catégorie a ajouter</h2>
            <div class="col-3 mb-5">
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
            <div class="d-flex justify-content-evenly">
                <button class="btn btn-primary mb-5 " name="submit" type="submit">Ajouter</button>
            </div>     
        </form>
    </div>
</div>
<?php
 
 $contenu = ob_get_clean();
 $title = "ajouter film";
 require "views/template.php";