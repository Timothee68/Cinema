<?php
// démarre la temporisation de sortie. 
// Tant qu'elle est enclenchée, aucune donnée, hormis les en-têtes, n'est envoyée au navigateur, mais temporairement mise en tampon.
    ob_start();
?>

<div class="container mb-5">
    <h1 class="mb-5 mt-5">Bienvenue sur Ciné Gaumont</h1>
    <img src="img_affiche/MGM_logo.jpg" class="acceuil card-img-top" alt="...">
</div>

<?php
// Lit le contenu courant du tampon de sortie puis l'efface.
// ob_get_clean() exécute successivement ob_get_contents() et ob_end_clean().
    $contenu = ob_get_clean();
    $title ="page d'acceuil"; 
    require "./views/template.php";