<?php
//ob_start()  Active la mise en mémoire tampon de sortie
    ob_start();
?>

<div class="container-fluid">
    <h1>Les films</h1>
    <div class="row">
        <div class="d-flex justify-content-evenly">
            <button type="button" class="btn btn-lg mt-2 "><a href="index.php?action=ajouterFilm">Ajouter un film a la liste</a></button>
        </div>
    </div>
    <div class="row row-cols-md-5 g-4 mt-5 d-flex justify-content-evenly">
        <?php foreach ($films->fetchAll() as $film) : ?>
            <div class="card m-2 mt-4 mb-4 bg-dark">
                    <figure>
                        <a href="index.php?action=detailFilm&id=<?= $film['id_film'] ?>"><img src="<?= $film['affiche'];?>" class="detail-film card-img-top" style="max-height:200px;" alt="..."></a>
                    </figure>
                <div class="card-text">
                    <h5 class="card-title text-center"><a href="index.php?action=detailFilm&id=<?= $film['id_film'] ?>"><?= $film['titre_film'] ?></a></h5>
                </div>
                <hr class="bg-light">
                <div class="dropdown d-flex justify-content-evenly">
                    <button class="btn btn-primary text-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Editer
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <button type="button" class="btn btn-lg "><a href="index.php?action=modifierFilm&id=<?= $film['id_film']?>">Modifier</a></button>
                        <button type="button" class="btn btn-lg "><a href="index.php?action=deletFilm&id=<?= $film['id_film'] ?>">Supprimer </a></button>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>        
<?php
//  ob_get_clean() Lit le contenu courant du tampon de sortie puis l'efface
$contenu = ob_get_clean();
$title ="liste films"; 
require "./views/template.php";