<?php
    ob_start();
?>

<div class="container-fluid">
    <h1>Les acteurs</h1>
    <div class="row">
        <div class="d-flex justify-content-evenly">
            <button type="button" class="btn btn-lg  mt-2 "><a href="index.php?action=ajouterActeur">Ajouter un acteur a la liste</a></button>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-6 g-4 mt-5 d-flex justify-content-evenly">
        <?php foreach ($acteurs->fetchAll() as $acteur) : ?>
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
</div>

<?php
    $contenu = ob_get_clean();
    $title ="liste acteurs";
    require "./views/template.php";


