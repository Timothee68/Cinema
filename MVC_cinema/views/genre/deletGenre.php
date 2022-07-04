<?php 
    ob_start();
?>

<h1 class="mb-5 mt-5">Supprimer un genre</h1>



<!-- <h2>supprimer genre</h2> -->
<div class="container mt-5">
    <div class="row d-flex justify-content-evenly">
        <div class="col-6">
            <form action="index.php?action=deletGenre" method="post">
                <select name="id_genre" class="form-select mb-5" aria-label="Default select example">
                    <option selected>Selectionne un genre</option>
                        <?php foreach ($requestDelet ->fetchAll() as $genre) : ?>
                           <option value="<?=$id= $genre['id_genre']?>"><?= $genre['libelle'] ?></option>
                        <?php  endforeach; ?> 
                </select>
                <div class="mt-5 d-flex justify-content-evenly">
                    <button class="btn btn-primary mb-5 " name="submit" type="submit">supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

$contenu = ob_get_clean();
$title = "supprimer film ";
require "./views/template.php";