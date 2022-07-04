<?php
    ob_start();
   $acteur = $requetActeur->fetch();
?>


<div class="container">
    <h1 class="mb-5 mt-5" >Rôle jouer par <?= $acteur['acteur']?></h1>
    <div class="row row-col-4 g-3 ">
    <form action="index.php?action=addRole&id=<?=$acteur['id_acteur']?>" method="post">
        <div class="row d-flex justify-content-evenly">
            <div class="mb-5 col-6 ">
                <label for="formGroupExampleInput" class="form-label">Nom du personnage jouer</label>
                <input name="nom_personnage" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
            </div>
            <select name="id_film" class="form-select form-select-lg mb-5 text-center col-7 " aria-label="Default select example">
                <option selected>Choisis le film qui correspond au role</option>
            <?php foreach($listsFilm as $film) : ?>
                <option value="<?= $film['id_film']?>"><?=$film['titre_film']?></option>
            <?php endforeach ?>
            </select>
        </div>
        <div class="d-flex justify-content-evenly" >
            <button class="btn btn-primary mt-5 " name="submit" type="submit">Ajouter</button>
        </div>
        </form>
    </div>
</div>

<?php
    $contenu = ob_get_clean();
    $title ="liste acteurs";
    require "./views/template.php";
