<?php
    ob_start();
?>

<h1 class="mb-5 mt-5">Ajouter un réalisateur</h1>

<div class="container mb-5">
    <div class="row row-col-4 g-3">
    <form action="index.php?action=ajouterRealisateur" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Nom</label>
                <input name="nom" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
            </div>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Prénom</label>
                <input name="prenom" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
            </div>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput2" class="form-label">Date de Naissance</label>
                <input name="date_naissance" type="date" class="form-control" id="formGroupExampleInput2" placeholder="Example input placeholder">
            </div>
        </div>
        <div class="row d-flex justify-content-evenly">
            <select name="sexe" class="form-select mb-5" aria-label="Default select example" required="required">
                <option selected>Choix sexe</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
            <div class="mb-5 col-4">
                <label for="formGroupExampleInput" class="form-label">Origine</label>
                <input name="origine" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
            </div>
            <div class="mb-5 col-4">
                <label for="formFile" class="form-label">Choisis de la photo du réalisateur</label>
                <input name="image_realisateur" type="file" class="form-control" id="formFile">
            </div>
        </div>
        <div class="mb-5 col-12">
            <label for="exampleFormControlTextarea1" class="form-label">biographie</label>
            <textarea name="biographie" class="form-control" id="exampleFormControlTextarea1" rows="3" required="required"></textarea>
        </div>
        <div  class="d-flex justify-content-evenly">
            <button class="btn btn-primary mb-5 " name="submit" type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajouter</button>
        </div>
        </form>
    </div>
</div>    



<?php
 
 $contenu = ob_get_clean();
 $title = "ajouter realisateur";
 require "views/template.php";


