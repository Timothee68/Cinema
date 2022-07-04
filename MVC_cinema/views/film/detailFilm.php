<?php
    ob_start();
    $film = $stmtFilms->fetch();
?>
<div class="col d-flex justify-content-evenly">
    <div class="card mb-3  mt-5" style="max-width: 540px;">
        <img src="<?= $film['affiche'];?>" class="detail-film card-img-top"  alt="...">
        <div class="card-body">
            <h2 class="card-title text-center"><?=$film['titre'];?></h2>
            <p class="card-text text-center"><strong><a href="index.php?action=detailGenre&id=<?= $film['id_genre']?>"><?=$film['libelle']?></a></strong>
                <?php foreach ($stmtFilms->fetchAll() as $genre) : ?>
                /<strong><a href="index.php?action=detailGenre&id=<?= $genre['id_genre']?>"><?= $genre['libelle']?></a></strong> 
            <?php endforeach; ?>
            /</p>
            <p class="card-text text-center"><strong>Synopsis : </strong> </p>
            <p class="card-text"><?=$film['synopsis'];?></p>
            <p class="card-text text-center">Réalisé(e) par <a href="index.php?action=detailRealisateur&id=<?= $film['id_realisateur']?>"><?=$film['realisateur'];?></a></p>
            <p class="card-text text-center">Durée :<?=$film['duree'];?></p>
            <p class="card-text text-center"><?=$film['note'];?> sur 5</p>
            <p class="card-text text-center"><?php $i=0; while ($i < $film['note']){ echo "<i class='fa-solid fa-star'></i>"; $i++; };?></p>
            <p class="card-text text-center"><small class="text-muted">Sortie le : <?=$film['annee_sortie'];?></small></p>
        </div>
    </div>
    <div class="col-4">
        <div class="card mt-5" >
            <h2 class="card-title text-center">Filmographie</h2>
            <ul class="list-group list-group-flush">
                <?php foreach ( $stmtCasting->fetchAll() as $casting) : ?>
                    <li class="list-group-item"><a href="index.php?action=detailActeur&id=<?= $casting['id_acteur']?>"><?= $casting['acteur'] ?></a> qui joue dans le rôle de <strong><?=$casting['role_jouer']?></strong></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>     
<?php
$contenu = ob_get_clean();
$title ="films"; 
require "./views/template.php";

