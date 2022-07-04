<?php 
    ob_start();
?>

<h1 class="mb-5 mt-5" >Rajouter une catégorie de film</h1>

<div class="container mb-5">
    <div class="row g-0">
        <form action="index.php?action=ajouterGenre" method="post">
            <div class="row d-flex justify-content-evenly">
                <div class="mb-5 col-4">
                    <label for="formGroupExampleInput" class="form-label">Catégorie</label>
                    <input name="libelle" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder" required="required">
                </div>
            </div>
            <div class="d-flex justify-content-evenly">
                <button class="btn btn-primary mb-5 " name="submit" type="submit">Ajouter</button>
            </div>
        </form>
    </div>
</div>
<?php
     $contenu = ob_get_clean() ;
     $title = "ajouter genre";
     require "./views/template.php";
?>



