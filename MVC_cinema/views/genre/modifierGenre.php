<?php
    ob_start();
?>

<h1 class="mb-5 mt-5">Modifier une catégorie</h1>

<div class="container">
    <form action="index.php?action=modifierGenre" method="post">
        <div class="row d-flex justify-content-evenly">
            <select name="id_genre" class="form-select mb-5 col-4" aria-label="Default select example">
                <option selected>Choisis une catégorie a modifier</option>
            <?php foreach($requestUpdate as $genre) : ?>
                <option value="<?= $genre['id_genre']?>"><?= $genre['libelle']?></option>
            <?php endforeach ?>
            </select>
        </div>
        <div class="row d-flex justify-content-evenly">    
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Nouveaux nom pour la catégorie</label>
                <input name="libelle" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" ">
            </div>
        </div>
        <div class="d-flex justify-content-evenly">  
        <button class="btn btn-primary mb-5 " name="submit" type="submit">Modifier</button>
        </div>
    </form>
</div>


<?php
    $contenu = ob_get_clean();
    $title = "modifier une catégorie";
    require "./views/template.php";