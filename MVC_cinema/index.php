<?php 
//  require_once permet de demander une fois la page demander puis la libére pour qu'elle soit consulté par d'autre page 
require_once "controllers/AcceuilController.php";
require_once "controllers/ActeurController.php";
require_once "controllers/FilmController.php";
require_once "controllers/GenreController.php";
require_once "controllers/RealisateurController.php";
require_once "controllers/RechercheController.php";

// on crée des variables contrôle puis le nom de la page concerner et on lui donne en valeur la création d'un objet en liens avec la page souhaitée 

$ctrlAcceuil = new AcceuilController ;
$ctrlActeur = new ActeurController ;
$ctrlFilm = new FilmController;
$ctrlGenre= new GenreController;
$sctrlRealisateur = new RealisateurController;
$ctrlRecherche = new RechercheController;

 if (isset($_GET["action"]))
 {
   switch($_GET["action"])
   {
// section film 
      case 'listsFilms': 
         $ctrlFilm->findAll();
         break;

      case 'detailFilm':
         $ctrlFilm->findByOneId($_GET["id"]);
         break;

      case 'ajouterFilm' :
         $ctrlFilm->addFilm();
         break; 

      case 'modifierFilm' : 
         $ctrlFilm->modifierFilm($_GET["id"]);
         break;

      case 'deletFilm' :
         $ctrlFilm->deletFilm($_GET["id"]);
         break;     
// section acteur
      case 'listsActeurs' :
         $ctrlActeur->findAll();
         break;
      
      case 'detailActeur' :
         $ctrlActeur->findActeurById($_GET["id"]);
         break;

      case 'ajouterActeur' :
         $ctrlActeur->addActeur();
         break;

      case 'deletActeur' : 
         $ctrlActeur->deletActeur($_GET["id"]);
         break;   

      case 'addRole' :
         $ctrlActeur->addRole($_GET["id"]);
         break;
      
      case 'modifierActeur' :
         $ctrlActeur->modifierActeur($_GET["id"]);
         break;
// section genre
      case 'listsGenres' :
         $ctrlGenre->findAll();
         break;

      case 'detailGenre' :
         $ctrlGenre->findFilmByGenre($_GET["id"]);
         break;
      
      case 'ajouterGenre' :  
         $ctrlGenre->addGenre();
         break;
         
      case 'deletGenre' :
            $ctrlGenre->deletGenre();
            break;

      case 'modifierGenre' : 
            $ctrlGenre->modifierGenre();
            break;
  
            //marche pas ...
            
      case 'ajouterGenreFilm' :  
            $ctrlGenre->addGenreForFilm();
            break;

         
// section realisateur
      case 'listsRealisateurs' :
         $sctrlRealisateur->findAll();
         break;

      case 'detailRealisateur' :
         $sctrlRealisateur->findByOneID($_GET["id"]);
         break;

      case 'ajouterRealisateur' : 
         $sctrlRealisateur->addRealisateur();
         break;

      case 'deletRealisateur' : 
         $sctrlRealisateur->deletRealisateur($_GET["id"]);
         break;
      case 'modifierRealisateur' : 
         $sctrlRealisateur->modifierRealisateur($_GET["id"]);
         break;      
// section acceuil
      case 'acceuil' : 
         $ctrlAcceuil->pageAcceuil();
         break;
// recherche
      case 'recherche' : 
         $ctrlRecherche->search($_POST['resultat']);
         // $ctrlRecherche->findSearch();
         break;
   }
}else{
   $ctrlAcceuil->pageAcceuil();
}


