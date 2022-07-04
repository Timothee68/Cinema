<?php
require_once "app/DAO.php";

class RechercheController 
{
    // fonction de recherche 
    public function search($data)
    {   
        if (isset($_POST['resultat']))
        //   AND !empty($_GET['resultat'])
        { 
            $data = filter_input(INPUT_POST,'resultat',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);

            $dao = new DAO;
            //requete sql recherche acteur
            $sqlActeur = "SELECT CONCAT(nom ,' ', prenom) AS acteur, id_acteur , image_acteur
                        FROM acteur
                        WHERE nom  LIKE :resultat 
                        OR prenom LIKE :resultat 
                        OR CONCAT(nom ,' ', prenom) LIKE :resultat 
                        OR CONCAT(prenom ,' ', nom) LIKE :resultat ";
            $rechercheActeur = $dao->executerRequete($sqlActeur, ["resultat" => '%'.$data.'%']);    
                 
            //requete sql recherche genre
            $sqlGenre = "SELECT libelle , id_genre
                        FROM genre 
                        WHERE libelle LIKE :resultat";
            $rechercheGenre = $dao->executerRequete($sqlGenre, ["resultat" => '%'.$data.'%']);

            //requete sql recherche realisateur
            $sqlRealisateur = "SELECT CONCAT(prenom, ' ', nom) as realisateur , image_realisateur , id_realisateur
                            FROM realisateur 
                            WHERE nom
                            OR prenom LIKE :resultat 
                            OR CONCAT(nom ,' ', prenom) LIKE :resultat 
                            OR CONCAT(prenom ,' ', nom) LIKE :resultat ";
            $rechercheRealisateur = $dao->executerRequete($sqlRealisateur, ["resultat" => '%' .$data. '%']);
            //requete sql recherche film
            $sqlFilm = "SELECT f.id_film as id_film, f.titre_film as titre_film , f.synopsis ,TIME_FORMAT(SEC_TO_TIME (f.duree_min *60 ),'%h:%i') 
                         AS duree ,DATE_FORMAT(f.annee_sortie, '%d %M %Y')AS annee_sortie ,f.note , CONCAT(r.nom, ' ',r.prenom) as realisateur, r.id_realisateur as id_realisateur, f.affiche as affiche
                        FROM film f
                        INNER JOIN realisateur r ON r.id_realisateur = f.realisateur_id
                        WHERE titre_film LIKE :resultat";
            $rechercheFilm = $dao->executerRequete($sqlFilm, ['resultat' => '%'.$data.'%' ]);           
        } else {
            echo "<p class='bg-danger'>rentre une recherche pardis </p>";

        }

        require "views/search/listsSearch.php";
    }   
}


