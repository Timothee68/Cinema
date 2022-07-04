<?php
// on require la page DAO pour l'exuction de des requetes SQL
require_once "app/DAO.php";

class FilmController
{
    // fonction qui permet de récupéré tous les films et afficher dans la liste des films
    public function findAll()
    {
        $dao = new DAO;
        $sql = "SELECT f.id_film as id_film, f.titre_film as titre_film, TIME_FORMAT(SEC_TO_TIME (f.duree_min *60 ),'%h:%i') AS duree ,
        CONCAT(r.nom,' ',r.prenom) as realisateur , r.id_realisateur as id_realisateur,  f.affiche as affiche
        FROM film f
        INNER JOIN realisateur r ON r.id_realisateur = f.realisateur_id";
        $films = $dao->executerRequete($sql);
        
        require "views/film/listsFilms.php";
    }
    // fonction qui récupère les films par leur id et affiche leur informations pour chaquue film 
    public function findByOneId($id)
    {
        $dao = new DAO;
        $sql = "SELECT f.id_film as id_film, f.titre_film as titre , f.synopsis ,TIME_FORMAT(SEC_TO_TIME (f.duree_min *60 ),'%h:%i') 
        AS duree ,DATE_FORMAT(f.annee_sortie, '%d %M %Y')AS annee_sortie ,f.note , CONCAT(r.nom, ' ',r.prenom) as realisateur, r.id_realisateur as id_realisateur, f.affiche as affiche , libelle , g.id_genre as id_genre
        FROM film f
        INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
        INNER JOIN  posseder p  ON p.film_id = f.id_film
        inner join genre g on p.genre_id = g.id_genre
        WHERE id_film = :id ";
        
        $sqlCasting="SELECT CONCAT(a.nom,' ', a.prenom) as acteur , r.nom_personnage as role_jouer , a.id_acteur as id_acteur, c.film_id as film_id
        FROM acteur a 
        INNER JOIN casting c ON c.acteur_id = a.id_acteur
        INNER JOIN film f ON f.id_film = c.film_id
        INNER JOIN role r ON r.id_role = c.role_id
        WHERE f.id_film = :id";
        
        $stmtFilms = $dao->executerRequete($sql, ['id' => $id] );
        $stmtCasting = $dao->executerRequete($sqlCasting, ['id' => $id]);

        require "views/film/detailFilm.php";
    }

    
    // fonction d'ajout d'un film pour un réalisateur
    public function addFilm()
    { 
        //  on récupere les nom et id des réalisateur pour le choix deroulant du réalisateur auxquel on veut ajouter un film 
        $dao = new DAO;
        $sql = "SELECT CONCAT(r.nom,' ',r.prenom) as realisateur, r.id_realisateur
                FROM realisateur r
                ORDER BY r.nom ";
        $listRealisateur = $dao->executerRequete($sql);
                      
        $sqlSelectionGenre ="SELECT g.id_genre AS genre_id , g.libelle as libelle FROM genre g";
        $requestSelection = $dao->executerRequete($sqlSelectionGenre);
            // si on a cliquer sur le bouton d'envoie du formulaire 
            if(isset($_POST['submit']))
            {
                // Et si on bien remplie les champs demander ci dessous 
                if(isset($_POST['titre_film']) && isset($_POST['duree_min'])&& isset($_POST['annee_sortie']) && isset($_POST['synopsis']) && isset($_POST['note']) && isset($_POST['realisateur_id']) 
                && isset($_POST['genre_id'])
                )
                {
                    // on protège le formulaire de la faille xss
                    $titreFilm = filter_input(INPUT_POST,"titre_film",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                    $anneeSortie = filter_input(INPUT_POST,'annee_sortie',FILTER_SANITIZE_NUMBER_INT,FILTER_VALIDATE_INT);
                    $dureeMin = filter_input(INPUT_POST,'duree_min',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                    $synopsis = filter_input(INPUT_POST,'synopsis',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                    $note = filter_input(INPUT_POST,'note',FILTER_VALIDATE_FLOAT,FILTER_SANITIZE_NUMBER_FLOAT);
                    $realisateur =filter_input(INPUT_POST,'realisateur_id',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                    
                    // on crée une requête qui verifie si le titre_film existe deja en comparant le titre entrée et la base de donnée
                    $sqlCheckiSFilmExist =("SELECT f.titre_film FROM film f WHERE f.titre_film = :titre_film ");
                    $sqlCheck = $dao->executerRequete($sqlCheckiSFilmExist,[ "titre_film" => $titreFilm ]);
                    // si la requete ne trouve pas une ligne en base de donnée donc == 0 on execute la requête d'insert into 

                    if(isset($_FILES['affiche']))
                    {
                        // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                        $tmpName = $_FILES['affiche']['tmp_name'];
                        $name = $_FILES['affiche']['name'];
                        $size = $_FILES['affiche']['size'];
                        $error = $_FILES['affiche']['error'];

                        $tabExtension = explode('.', $name);
                        $extension = strtolower(end($tabExtension));

                        //Tableau des extensions que l'on accepte
                        $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                        //Taille max que l'on accepte
                        $maxSize = 400000;

                   
                        if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0)
                        {
                            // Génère un identifiant unique
                            $uniqueID = uniqid('', true );
                            $file = 'img_affiche/'.$uniqueID.'.'.$extension;
                            //  vaut l'id générer.jpg par exemple 
                            // Déplace un fichier téléchargé
                            move_uploaded_file($tmpName , './img_affiche/'.$name);
                            // il faut renomée le fichier avec l'uniqueiD et son extension car elle est enreigstrer en base de donnée de cet manière.
                            rename('./img_affiche/'.$name , './img_affiche/'.$uniqueID.'.'.$extension);
                            $affiche = $file;
                        }
                        else{
                            echo "<p class='bg-danger'>Mauvaise extension</p>";
                        };
                            if($sqlCheck->rowCount()==0)
                            {
                                // on insert into les infos dans la table film 
                                $dao = new DAO;    
                                $sql2="INSERT INTO film (titre_film , duree_min , annee_sortie , synopsis , note , affiche , realisateur_id)  
                                        VALUE ( :titre_film , :duree_min , :annee_sortie , :synopsis , :note , :affiche , :realisateur_id )";
                                $request = $dao->executerRequete($sql2, ["titre_film" => $titreFilm , "duree_min" => $dureeMin  , "annee_sortie" => $anneeSortie , "synopsis"=>$synopsis , "note" => $note , "affiche" => $affiche , "realisateur_id"=>$realisateur]);
                                //  on fetch pour récuperer la ligne de rentrée des infos 
                                $resultat = $request->fetch();

                                $sqlIdfilm ="SELECT f.id_film , f.titre_film
                                FROM film f 
                                WHERE f.titre_film = :titre_film ";
                                $requeteIdFilm = $dao->executerRequete($sqlIdfilm,['titre_film'=> $titreFilm]);
                                $idFilm= $requeteIdFilm->fetch();

                                    foreach ($_POST['genre_id'] as $genre_id)
                                    {
                                        // on préconise la faille xss
                                        $genre_id2 = htmlspecialchars($genre_id);
                                        $sql3="INSERT INTO posseder (film_id , genre_id ) VALUE (:film_id, :genre_id )" ;
                                        $request3= $dao->executerRequete($sql3,["film_id" => $idFilm['id_film'] , "genre_id" => $genre_id2 ]);
                                    }
                                // après que tout est été éffectuer on redirige sur la page de film ou on peut retrouver l'ajout du film 
                                header("location:index.php?action=listsFilms");
                            }else{
                                echo "<p class='bg-danger'>Le film existe déjà</p>";
                            }
                    }   
                } else {
                        echo "<p class='bg-danger'>Il manque des information pour enregister le film veuillez remplir tout les champs</p>";
                }
            }
        require "views/film/ajouterFilm.php";
    }

    // fonction pour supprimer un film et les clefs étrangères.
    public function deletFilm($id)
    {
        $dao = new DAO;
        $sql ="DELETE FROM posseder WHERE  film_id = :id_film";
        $sql2="DELETE FROM casting WHERE film_id = :id_film ";
        $sql3 = "DELETE FROM film WHERE id_film = :id_film ";
        $delet1=  $dao->executerRequete($sql,['id_film' => $id]);
        $delet2=  $dao->executerRequete($sql2,['id_film' => $id]);
        $delet3=  $dao->executerRequete($sql3,['id_film' => $id]);
        header("location:index.php?action=listsFilms");
    }


    public function modifierFilm($id)
    {
        $dao = new DAO;
        // on récupère les infos du film pour les mettres en pré-séléction du formulaire
        $sql = "SELECT f.titre_film as titre_film , f.synopsis ,f.duree_min AS duree_min , DATE_FORMAT(f.annee_sortie, '%Y-%m-%d') AS annee_sortie ,
        f.note as note , CONCAT(r.nom, ' ',r.prenom) as realisateur, r.id_realisateur as id_realisateur, f.affiche as affiche , f.id_film as id_film
        FROM film f
        INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
        WHERE id_film = :id_film ";
        $stmtFilms = $dao->executerRequete($sql, ['id_film' => $id] );
        // on récupere les réalisateurs pour la séléction de la clef étrangère 
        $sql2 = "SELECT CONCAT(r.nom,' ',r.prenom) as realisateur, r.id_realisateur
        FROM realisateur r
        ORDER BY r.nom ";
        $listRealisateur = $dao->executerRequete($sql2);
        // on récupère les genres pour la séléction des genres
        $sqlSelectionGenre ="SELECT g.id_genre AS genre_id , g.libelle as libelle FROM genre g";
        $requestSelection = $dao->executerRequete($sqlSelectionGenre);
       
            // si on a cliquer sur le bouton d'envoie du formulaire 
        if(isset($_POST['submit']))
        {
            // Et si on bien remplie les champs demander ci dessous 
            if( isset($_POST['titre_film']) && isset($_POST['duree_min']) &&  isset($_POST['annee_sortie']) && isset($_POST['synopsis'])
                && isset($_POST['note']) && isset($_POST['id_realisateur']) 
                && isset($_POST['genre_id'])
                )
            {
                // on protège le formulaire de la faille xss
                $titreFilm = filter_input(INPUT_POST,"titre_film",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $anneeSortie = filter_input(INPUT_POST,'annee_sortie',FILTER_SANITIZE_NUMBER_INT,FILTER_VALIDATE_INT);
                $dureeMin = filter_input(INPUT_POST,'duree_min',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                $synopsis = filter_input(INPUT_POST,'synopsis',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $note = filter_input(INPUT_POST,'note',FILTER_VALIDATE_FLOAT,FILTER_SANITIZE_NUMBER_FLOAT);
                $realisateur = filter_input(INPUT_POST,'id_realisateur',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
    
                if(isset($_FILES['affiche']))
                {
                    // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                    $tmpName = $_FILES['affiche']['tmp_name'];
                    $name = $_FILES['affiche']['name'];
                    $size = $_FILES['affiche']['size'];
                    $error = $_FILES['affiche']['error'];

                    $tabExtension = explode('.', $name);
                    $extension = strtolower(end($tabExtension));

                    //Tableau des extensions que l'on accepte
                    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                    //Taille max que l'on accepte
                    $maxSize = 400000;

               
                    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0)
                    {
                        // Génère un identifiant unique
                        $uniqueID = uniqid('', true );
                        $file = 'img_affiche/'.$uniqueID.'.'.$extension;
                        //  vaut l'id générer.jpg par exemple 
                        // Déplace un fichier téléchargé
                        move_uploaded_file($tmpName , './img_affiche/'.$name);
                        // il faut renomée le fichier avec l'uniqueiD et son extension car elle est enreigstrer en base de donnée de cet manière.
                        rename('./img_affiche/'.$name , './img_affiche/'.$uniqueID.'.'.$extension);
                        $affiche = $file;
                    }
                    else{
                        echo "<p class='bg-danger'>Mauvaise extension</p>";
                    }
                        // on modifie le film 
                        $dao = new DAO();
                        $sql3 ="UPDATE film SET titre_film = :titre_film , annee_sortie = :annee_sortie , duree_min = :duree_min ,
                                synopsis = :synopsis , note = :note , affiche = :affiche , realisateur_id = :id_realisateur
                                WHERE id_film = :id_film ";
                        $execute = $dao->executerRequete($sql3,[ "titre_film" => $titreFilm , "duree_min" => $dureeMin , "annee_sortie" => $anneeSortie ,
                                            "synopsis"=>$synopsis , "note" => $note , "affiche" => $affiche ,"id_realisateur"=>$realisateur,
                                            "id_film" => $id ]);  
                         
                        
                        // on supprime les genres 
                        $sql5="DELETE FROM posseder WHERE film_id = :id_film ";
                        $dao->executerRequete($sql5,['id_film' => $id]);
                      
                        // on rajoute les nouveaux genres au film
                        // echo $id; 
                       
                        foreach ($_POST['genre_id'] as $genre_id)
                        {
                         
                            $genre_id2 = htmlspecialchars($genre_id);
                            
                            $sql4="INSERT INTO posseder (film_id , genre_id ) VALUE (:id_film , :genre_id )" ;
                        
                            $request3= $dao->executerRequete($sql4,["id_film" =>$id, "genre_id" => $genre_id2]);
                          
                        }
                    header("location:index.php?action=listsFilms");                     
                }    
            }
        }
        require "views/film/modifierFilm.php";
    }

}
 
 