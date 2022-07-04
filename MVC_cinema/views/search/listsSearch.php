<?php 
    ob_start();
?>
<h1>Résultat recherche</h1>


<!-- resultat par genre -->
<div class="row row-cols-md-4 g-4 mt-5 d-flex justify-content-evenly">
<?php foreach ($rechercheGenre->fetchAll() as $genre) : ?>
        <div class="card m-2 bg-dark">
            <div class="card-body text-center bg-dark">
                <h5><a href="index.php?action=detailGenre&id=<?= $genre['id_genre']?>"><?= $genre['libelle'] ?></a></h5>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- resultat par acteur -->
<div class="row row-cols-1 row-cols-md-6 g-4 mt-5 d-flex justify-content-evenly">
    <?php foreach ($rechercheActeur->fetchAll() as $acteur) : ?>
        <div class="card m-2 mt-4 mb-4 bg-dark">
                <figure>
                    <a href="index.php?action=detailActeur&id=<?=$acteur['id_acteur']?>"><img src="<?=$acteur['image_acteur'];?>" class="img-fluid card-img-top" style="max-height:180px;" alt="..."></a>
                </figure>
            <div class="card-text">
                <h5 class="card-title text-center"><a href="index.php?action=detailActeur&id=<?=$acteur['id_acteur']?>"><?= $acteur['acteur'] ?></a></h5>
            </div>
            <hr class="bg-light">
            <div class="dropdown d-flex justify-content-evenly">
                <button class="btn btn-primary text-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Editer
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <button type="button" class="btn btn-lg "><a href="index.php?action=addRole&id=<?=$acteur['id_acteur']?>">Ajouter un rôle</a></button>
                    <button type="button" class="btn btn-lg "><a href="index.php?action=modifierActeur&id=<?=$acteur['id_acteur']?>">Modifier</a></button>
                    <button type="button" class="btn btn-lg"><a href="index.php?action=deletActeur&id=<?=$acteur['id_acteur']?>">Supprimer</a></button>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>        
<!-- resultat par réalisateur-->
  
<div class="row row-cols-1 row-cols-md-6 g-4 mt-5 d-flex justify-content-evenly">
    <?php foreach ($rechercheRealisateur->fetchAll() as $resultatRealisateur) : ?>
        <div class="card m-2 mt-4 mb-4 bg-dark">
                <figure>
                    <a href="index.php?action=detailRealisateur&id=<?= $resultatRealisateur['id_realisateur'] ?>"><img src="<?=$resultatRealisateur['image_realisateur'];?>" class="img-fluid card-img-top" style="max-height:200px;"  alt="..."></a>
                </figure>
            <div class="card-text">
                <h5 class="card-title text-center"><a href="index.php?action=detailRealisateur&id=<?= $resultatRealisateur['id_realisateur'] ?>"><?= $resultatRealisateur['realisateur'] ?></a></h5>
            </div>
            <hr class="bg-light">
            <div class="dropdown d-flex justify-content-evenly">
                <button class="btn btn-primary text-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Editer
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <button type="button" class="btn btn-lg "><a href="index.php?action=modifierRealisateur&id=<?=$resultatRealisateur['id_realisateur']?>">Modifier</a></button>
                    <button type="button" class="btn btn-lg "><a href="index.php?action=deletRealisateur&id=<?= $resultatRealisateur['id_realisateur'] ?>">Supprimer</a></button>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- resultat par film  -->
<div class="row row-cols-md-5 g-4 mt-5 d-flex justify-content-evenly">
<?php foreach ($rechercheFilm->fetchAll() as $film) : ?>
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
    </div
<?php
     $contenu = ob_get_clean() ;
     $title = "les recherches";
     require "./views/template.php";
    