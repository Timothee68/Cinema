
<?php
    ob_start();
    $real = $realisateur->fetch();
?>

<h1 class="mb-5 mt-5">Modifier <?= $real['prenom'].' '.$real['nom']?></h1>

<div class="container mb-5">
    <div class="row row-col-4 g-3 ">
        <form action="index.php?action=modifierRealisateur&id=<?=$real['id_realisateur']?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Nom</label>
                <input name="nom" type="text" class="form-control" id="formGroupExampleInput" value="<?=$real['nom']?>" >
            </div>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Prénom</label>
                <input name="prenom" type="text" class="form-control" id="formGroupExampleInput" value="<?=$real['prenom']?>">
            </div>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput2" class="form-label">Date de Naissance</label>
                <input name="date_naissance" type="date" class="form-control" id="formGroupExampleInput2" value="<?=$real['date_naissance']?>" required="required">
            </div>
        </div>
        <div class="row d-flex justify-content-evenly">
            <select name="sexe" class="form-select mb-5" aria-label="Default select example" >
                <option selected>Choix sexe</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Origine</label>
                <input name="origine" type="text" class="form-control" id="formGroupExampleInput" value="<?=$real['Origine']?>" >
            </div>
            <div class="mb-5 col-4">
                <label for="formFile" class="form-label">Choisis de la photo du realisateur</label>
                <input name="image_realisateur" type="file" class="form-control" id="formFile">
            </div>
        </div>
        <div class="mb-3 col-12 mb-5">
            <label for="exampleFormControlTextarea1" class="form-label">biographie</label>
            <textarea name="biographie" class="form-control" id="exampleFormControlTextarea1" rows="3"><?=$real['biographie']?></textarea>
        </div>
        <div class="d-flex justify-content-evenly">
            <button class="btn btn-primary mb-5 " name="submit" type="submit">Ajouter</button>
        </div>
        </form>
    </div>
</div>    

<?php
    $contenu = ob_get_clean();
    $title ="modifier realisateur";
    require "./views/template.php";


