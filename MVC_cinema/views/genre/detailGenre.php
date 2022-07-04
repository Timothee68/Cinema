<?php
    ob_start();
    $genre = $stmtgenres->fetch();
?>

<h1><?= $genre['libelle']?></h1>
<div class="card-group d-flex justify-content-evenly">
    <?php foreach ( $stmtgenres2->fetchAll() as $film) : ?>
        <div class="card  mt-4 mb-4 col-3">
            <div class="img">
                <figure>
                    <img src="<?= $film['affiche'];?>" class="detail-film card-img-top" style="max-height:200px;" alt="...">
                </figure>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center"><a href="index.php?action=detailFilm&id=<?= $film['id_film'] ?>"><?= $film['titre_film'] ?></a></h5>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
$contenu = ob_get_clean();
$title ="films"; 
require "./views/template.php";