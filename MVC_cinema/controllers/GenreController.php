<?php
 require_once "app/DAO.php";
class GenreController
{
    // trouve tout les genres qui sont possédé par un film !!! si je veux récupérer que les genres faire une autre requête
    function findAll()
    {
        $dao = new DAO;
        $sql = "SELECT g.libelle as libelle ,COUNT(p.genre_id) AS nb_film_par_genre , g.id_genre as id_genre
                FROM genre g
                LEFT JOIN posseder p ON p.genre_id = g.id_genre
                GROUP BY g.id_genre";
        $genres = $dao->executerRequete($sql);

        require "views/genre/listsGenre.php";
    }

    function findFilmByGenre($id)
    {
        $dao = new DAO;
        $sql = "SELECT libelle as libelle
        FROM genre
        WHERE id_genre = :id";

        $sql2 ="SELECT p.film_id as id_film, p.genre_id , f.titre_film AS titre_film , g.libelle AS libelle , f.affiche
                FROM posseder p
                INNER JOIN film f ON f.id_film = p.film_id
                INNER JOIN genre g ON g.id_genre = p.genre_id
                WHERE p.genre_id =  :id";
        $stmtgenres =$dao->executerRequete($sql, ["id"=> $id]);
        $stmtgenres2 =$dao->executerRequete($sql2, ["id"=> $id]);

        require "views/genre/detailGenre.php";
    }
// fonction pour ajouter un genre
    public function addGenre()
    {
        if(isset($_POST['submit']))
        {
            if(isset($_POST['libelle']))
            {
                $libelle = filter_input(INPUT_POST,'libelle',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);

                $dao = new DAO;
                // on crée une requête qui verifie si le titre_film existe deja en comparant le titre entrée et la base de donnée
                $sqlCheckIsGenreExist =("SELECT g.libelle FROM genre g WHERE g.libelle = :libelle");
                $sqlCheck = $dao->executerRequete($sqlCheckIsGenreExist,[ "libelle" => $libelle]);
                // si la requete ne trouve pas une ligne en base de donnée donc == 0 on execute la requête d'insert into 
                if($sqlCheck->rowCount()==0)
                {
                    $sqlGenre =("INSERT INTO genre ( libelle) VALUE ( :libelle) ");
                    $request = $dao->executerRequete($sqlGenre,['libelle' => $libelle]);
                    $resultat = $request->fetch();
                    header("location:index.php?action=listsGenres");

                }else{
                    echo "<p class='bg-danger'>La catégorie existe déjà</p>";
                }
            }
        }
        require "views/genre/ajouterGenre.php";
    } 
    // fonction pour supprimer un genre 
    public function deletGenre()
    {
        
        $dao = new DAO;
        $sqlDelete ="SELECT g.id_genre AS id_genre, g.libelle AS libelle
        FROM genre g
        ORDER BY libelle";
        $requestDelet = $dao->executerRequete($sqlDelete);
        
        if(isset($_POST['submit']))
        {
            if(isset($_POST['id_genre']))
            {
                $genre =filter_input(INPUT_POST,'id_genre',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                $sql2 = "DELETE FROM posseder WHERE genre_id = :id_genre";
                $dao->executerRequete($sql2,['id_genre' => $genre ]);
                $sql = "DELETE FROM genre WHERE id_genre = :id_genre ";
                $delet = $dao->executerRequete($sql,['id_genre' => $genre ]);
                header("location:index.php?action=listsGenres");
            }
        }
        require "views/genre/deletGenre.php";
    }
// fonction pour modifier le nom d'un genre existant 
    public function modifierGenre(){

        $dao = new DAO;
        $sqlModifier ="SELECT g.id_genre AS id_genre, g.libelle AS libelle
        FROM genre g
        ORDER BY libelle";
        $requestUpdate = $dao->executerRequete($sqlModifier);
 
        if(isset($_POST['submit'])){
      
            if(isset($_POST['id_genre']) &&  isset($_POST['libelle'])){
                
                $genre = filter_input(INPUT_POST,'id_genre',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                $libelle = filter_input(INPUT_POST,'libelle',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                var_dump($libelle);
                var_dump( $genre);
                $sql = "UPDATE genre SET libelle = :libelle WHERE id_genre = :id_genre ";
                $dao->executerRequete($sql, ['id_genre' => $genre , 'libelle' => $libelle ]);

                header("location:index.php?action=listsGenres");
            }
        }
        require "views/genre/modifierGenre.php";
    }

    public function addGenreForFilm()
    {
        //  on récupere les id de film et genre pour pouvoir faire des sélcetions de titre de film et de catégorie
        $dao =new DAO();
        $sqlSelectionGenre ="SELECT g.id_genre AS genre_id , g.libelle as libelle FROM genre g";
        $requestSelection = $dao->executerRequete($sqlSelectionGenre);
 
        $sqlIdFilm = "SELECT f.titre_film, f.id_film FROM film f";
        $sqlRequeteFilm = $dao->executerRequete($sqlIdFilm);

        if( isset($_POST['film_id']) && isset($_POST['genre_id']) )
        {
            $film = filter_input(INPUT_POST,'film_id',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_input(INPUT_POST,'genre_id',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);   

                // on vérifei que le film n'a pas déjà la catégorie attribué
                $sqlCheckIsGenreExist ="SELECT f.titre_film as titre_film , f.id_film as id_film, g.libelle AS libelle , g.id_genre as id_genre
                                        FROM posseder p
                                        INNER JOIN film f ON f.id_film = p.film_id
                                        INNER JOIN genre g ON g.id_genre = p.genre_id 
                                        WHERE g.libelle = :libelle
                                        AND f.titre_film = :titre_film";
                $sqlCheck2 = $dao->executerRequete($sqlCheckIsGenreExist,[ "libelle" => $genre]);

                // si la requete ne trouve pas une ligne en base de donnée donc == 0 on execute la requête d'insert into 
                if($sqlCheck2->rowCount()==0)
                {
                    foreach ($_POST['genre_id'] as $genre_id)
                    {
                        $sql3="INSERT INTO posseder (film_id , genre_id ) VALUE (:film_id, :genre_id )" ;
                        $request3= $dao->executerRequete($sql3,["film_id" => $film, "genre_id" => $genre_id ]);
                        // $resultat3=$request3->fetch();
                    }
                    header("location:index.php?action=listsFilms");
                }else{
                    echo "<p class='bg-danger'>La catégorie à déjà été ajouter au film</p>";
                }
        }    
        require "views/genre/ajouterGenreFilm.php";
    }

 
}


