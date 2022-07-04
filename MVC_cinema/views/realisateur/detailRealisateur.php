<?php
    ob_start();
    $realisateur = $stmtRealisateurs->fetch();
?>

<h1><?=$realisateur["realisateur"];?></h1>

<div class="container-flui d-flex justify-content-center mt-5">
    <div class="row row-cols-md-5 g-4 mt-5 d-flex justify-content-evenly">
        <div class="card mb-3 " style="max-width: 540px;">
            <div class="col">
                <div class="row g-0 ">
                <img src="<?=$realisateur['image_realisateur'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"><strong>Née le </strong><?=$realisateur['date_naissance'];?></p>
                        <p class="card-text"><strong>Sexe : </strong><?=$realisateur['sexe'];?></p>
                        <p class="card-text"><strong>Nationalité :</strong><?=$realisateur['origine'];?></p>
                    </div>
                    <hr>
                    <div class="card-body">
                        <p class="card-text">Biographie : <?="</br>".$realisateur['biographie'];?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <h2 class="card-title text-center">Filmographie</h2>
                <ul class="list-group list-group-flush">
                    <?php foreach ($stmtRealisateurs2->fetchAll() as $film) : ?>
                        <li class="list-group-item"><a href="index.php?action=detailFilm&id=<?= $film['id_film'] ?>"><?= $film['titre_film'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
$contenu = ob_get_clean();
$title ="films par realisateur"; 
require "./views/template.php";

