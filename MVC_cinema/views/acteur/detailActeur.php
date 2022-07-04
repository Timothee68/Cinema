<?php
    ob_start();
    $acteur = $stmtActeurs->fetch();
?>

<h1><?=$acteur['acteur']?></h1>

<div class="container-fluid d-flex justify-content-center mt-5">
    <div class="row row-cols-md-5 g-4 mt-5 d-flex justify-content-evenly">
        <div class="card mb-3 " style="max-width: 540px;">
            <div class="col">
                <div class="row g-0 ">
                    <img src="<?=$acteur['image_acteur'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text"><strong>Née le </strong><?=$acteur['date_naissance'];?></p>
                        <p class="card-text"><strong>Sexe : </strong><?=$acteur['sexe'];?></p>
                        <p class="card-text"><strong>Nationalité :</strong> <?=$acteur['origine'];?></p>
                    </div>
                    <hr>
                    <div class="card-body">
                        <p class="card-text"><strong>Biographie : </strong> <?="</br>".$acteur['biographie'];?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <h2 class="card-title text-center">Filmographie</h2>
                <ul class="list-group list-group-flush">
                    <?php foreach ($stmtActeurs2->fetchAll() as $acteur) : ?>
                    <li class="list-group text-center"><a href="index.php?action=detailFilm&id=<?= $acteur['id_film'] ?>"><?= $acteur['titre_film'] ?></a></li>
                    <li class="list-group-item text-center">Joue le rôle de <?= $acteur['nom_personnage'] ?></li>  
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php
    $contenu = ob_get_clean();
    $title ="liste acteurs";
    require "./views/template.php";
?>

