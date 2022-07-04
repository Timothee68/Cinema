<?php
 require_once "app/DAO.php";

class ActeurController
{
        // requête pour trouver tous les acteurs 
    public function findAll()
    {
        $dao = new DAO;
        $sql = "SELECT CONCAT(nom,' ',prenom) AS acteur , id_acteur ,image_acteur 
                FROM acteur 
                ORDER BY nom";
        $acteurs = $dao->executerRequete($sql);
       
        require "views/acteur/listsActeur.php";
    }    
    // requête pour trouver les acteurs avec leurs information sexe date anniversaire photo et film jouer image etc
    
    public function findActeurById($id)
    {
        $dao = new DAO;
        $sql = "SELECT CONCAT(nom,' ',prenom) AS acteur ,DATE_FORMAT(date_naissance, '%d %M %Y')
                AS date_naissance , sexe , id_acteur , image_acteur , biographie , origine
                FROM acteur 
                WHERE id_acteur = :id";


        $sql2 = "SELECT r.nom_personnage as nom_personnage, f.titre_film as titre_film ,DATE_FORMAT(f.annee_sortie, '%d %M %Y') AS annee, f.id_film as id_film
        FROM acteur a 
        INNER JOIN casting c ON c.acteur_id = a.id_acteur
        INNER JOIN film f ON f.id_film = c.film_id
        INNER JOIN role r ON r.id_role = c.role_id
        WHERE a.id_acteur = :id
        ORDER BY f.annee_sortie DESC";
        $stmtActeurs = $dao->executerRequete($sql,['id' => $id]);
        $stmtActeurs2 =$dao->executerRequete($sql2,['id' => $id]);

        require "views/acteur/detailActeur.php";
    }

    public function addActeur()
    {
        if(isset($_POST['submit']))
        {
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['sexe']) && isset($_POST['biographie']) && isset($_POST['origine']) )
            {
                $nom = filter_input(INPUT_POST,"nom",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $prenom = filter_input(INPUT_POST,"prenom",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $dateNaissance = filter_input(INPUT_POST,'date_naissance',FILTER_SANITIZE_NUMBER_INT,FILTER_VALIDATE_INT); 
                $sexe = filter_input(INPUT_POST,"sexe",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                $biographie = filter_input(INPUT_POST,"biographie",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                $origine = filter_input(INPUT_POST,"origine",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                
                $dao = new DAO;
                // on crée une requête qui verifie si le titre_film existe deja en comparant le titre entrée et la base de donnée
                $sqlCheckiSActeurExist =("SELECT a.nom, a.prenom FROM acteur a WHERE a.nom = :nom  AND a.prenom = :prenom");
                $sqlCheck = $dao->executerRequete($sqlCheckiSActeurExist,[ "nom" => $nom, "prenom" => $prenom ]);
                // si la requete ne trouve pas une ligne en base de donnée donc == 0 on execute la requête d'insert into
                // si il existe un fichier de type files
                if(isset($_FILES['image_acteur']))
                {
                    // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                    $tmpName = $_FILES['image_acteur']['tmp_name'];
                    $name = $_FILES['image_acteur']['name'];
                    $size = $_FILES['image_acteur']['size'];
                    $error = $_FILES['image_acteur']['error'];

                    $tabExtension = explode('.', $name);
                    $extension = strtolower(end($tabExtension));

                    //Tableau des extensions que l'on accepte
                    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                    //Taille max que l'on accepte
                    $maxSize = 400000;

                    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                        // Génère un identifiant unique
                        $uniqueID = uniqid('', true );
                        $file = 'img_affiche/'.$uniqueID.'.'.$extension;
                        //  vaut l'id générer.jpg par exemple 
                        // Déplace un fichier téléchargé
                        move_uploaded_file($tmpName, './img_affiche/'.$name);
                        // il faut renomée le fichier avec l'uniqueiD et son extension car elle est enreigstrer en base de donnée de cet manière.
                        rename('./img_affiche/'.$name, './img_affiche/'.$uniqueID.'.'.$extension);
                        $imageActeur = $file;
                    }
                    else{
                        echo "Mauvaise extension";
                    };

                    if($sqlCheck->rowCount()==0)
                    {
                        $dao = new DAO();
                      
                        $sql ="INSERT INTO acteur ( nom, prenom , date_naissance , sexe , biographie , origine , image_acteur ) 
                                VALUE ( :nom, :prenom , :date_naissance , :sexe, :biographie, :origine, :image_acteur)" ;
                        $request = $dao->executerRequete($sql,["nom" => $nom , "prenom" => $prenom , "date_naissance" => $dateNaissance ,
                         "sexe" => $sexe , "biographie" => $biographie , "origine" => $origine , "image_acteur" => $imageActeur]);
                        $resultat = $request->fetch();
                        
                        header("location:index.php?action=listsActeurs");
                    }else{
                        echo "<p class='bg-danger'>L'acteur existe déjà</p>";
                    }
                }
            }else{
                echo "<p class='bg-danger'>Il manque des information pour enregister le film veuillez remplir tout les champs</p>";
            }
        }
        require "views/acteur/ajouterActeur.php";
    }

    public function deletActeur($id){

        $dao = new DAO;
        $sql="DELETE FROM casting WHERE acteur_id = :id_acteur";
        $sql2 = "DELETE FROM acteur WHERE id_acteur = :id_acteur ";
        $delet1=  $dao->executerRequete($sql,['id_acteur' => $id]);
        $delet2=  $dao->executerRequete($sql2,['id_acteur' => $id]);
        
        header("location:index.php?action=listsActeurs");
    }

    public function addRole($id){
        $dao = new DAO();
        $sql ="SELECT f.titre_film as titre_film , f.id_film as id_film
                FROM film f ";
        $listsFilm = $dao->executerRequete($sql);
        $sql2="SELECT CONCAT(a.nom,' ',a.prenom) as acteur,  a.id_acteur as id_acteur
                FROM acteur a
                WHERE id_acteur = :id_acteur";
        $requetActeur = $dao->executerRequete($sql2,["id_acteur" => $id]);

        if(isset($_POST['submit']))
        {
            if(isset($_POST['nom_personnage']) && isset($_POST['id_film']))
            {
                $role = filter_input(INPUT_POST,"nom_personnage",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $idFilm = filter_input(INPUT_POST,'id_film',FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);
                
                $sql3 =" INSERT INTO role (nom_personnage) VALUE ( :nom_personnage) ";
                $requete = $dao->executerRequete($sql3,['nom_personnage' => $role]);
                
                $sqlRole ="SELECT r.id_role , r.nom_personnage
                FROM role r 
                left JOIN casting c ON c.role_id = r.id_role
                WHERE r.nom_personnage = :nom_personnage ";
                $requeteRole = $dao->executerRequete($sqlRole,['nom_personnage'=> $role]);
                $roleId= $requeteRole->fetch();
                
                $sql4 = "INSERT INTO casting ( acteur_id , film_id , role_id ) VALUE ( :id_acteur , :id_film , :role_id)";
                $requete4 =$dao->executerRequete($sql4,['id_acteur'=>$id , 'id_film'=>$idFilm , 'role_id'=>$roleId['id_role']]);
                header("location:index.php?action=listsActeurs");
            }
        }
        require "views/acteur/addRole.php";
    }

    public function modifierActeur($id){

        $dao = new DAO();
        $sql ="SELECT * , DATE_FORMAT(date_naissance, '%Y-%m-%d') AS date_naissance
        FROM acteur
        WHERE id_acteur = :id_acteur ";
        $acteur = $dao->executerRequete($sql, ['id_acteur' => $id] );
        
        // var_dump($ac);die;

        if(isset($_POST['submit']))
        {
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['sexe']) && isset($_POST['biographie']) && isset($_POST['origine']) )
            {
                $nom = filter_input(INPUT_POST,"nom",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $prenom = filter_input(INPUT_POST,"prenom",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
                $dateNaissance = filter_input(INPUT_POST,'date_naissance',FILTER_SANITIZE_NUMBER_INT,FILTER_VALIDATE_INT); 
                $sexe = filter_input(INPUT_POST,"sexe",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                $biographie = filter_input(INPUT_POST,"biographie",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                $origine = filter_input(INPUT_POST,"origine",FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES); 
                
                $dao = new DAO;
                
                // si il existe un fichier de type files
                if(isset($_FILES['image_acteur']))
                {
                    // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                    $tmpName = $_FILES['image_acteur']['tmp_name'];
                    $name = $_FILES['image_acteur']['name'];
                    $size = $_FILES['image_acteur']['size'];
                    $error = $_FILES['image_acteur']['error'];

                    $tabExtension = explode('.', $name);
                    $extension = strtolower(end($tabExtension));

                    //Tableau des extensions que l'on accepte
                    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                    //Taille max que l'on accepte
                    $maxSize = 400000;

                    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
                        // Génère un identifiant unique
                        $uniqueID = uniqid('', true );
                        $file = 'img_affiche/'.$uniqueID.'.'.$extension;
                        //  vaut l'id générer.jpg par exemple 
                        // Déplace un fichier téléchargé
                        move_uploaded_file($tmpName, './img_affiche/'.$name);
                        // il faut renomée le fichier avec l'uniqueiD et son extension car elle est enreigstrer en base de donnée de cet manière.
                        rename('./img_affiche/'.$name, './img_affiche/'.$uniqueID.'.'.$extension);
                        $imageActeur = $file;
                    }
                    else{
                        echo "Mauvaise extension";
                    };

                   
                        $dao = new DAO();
                      
                        $sqlUpdate ="UPDATE acteur SET nom = :nom , prenom = :prenom ,date_naissance = :date_naissance , sexe = :sexe ,
                         biographie = :biographie , origine = :origine, image_acteur = :image_acteur
                         WHERE id_acteur = :id_acteur ";

                        $request = $dao->executerRequete($sqlUpdate,["nom" => $nom,"prenom" => $prenom,"date_naissance" => $dateNaissance,
                                "sexe" => $sexe, "biographie" => $biographie, "origine" => $origine, "image_acteur" => $imageActeur,
                                "id_acteur" => $id ]);
                        $resultat = $request->fetch();
                        // var_dump($resultat);die;
                     
                        header("location:index.php?action=listsActeurs");
                }
            }else{
                echo "<p class='bg-danger'>Il manque des information pour enregister le film veuillez remplir tout les champs</p>";
            }
        }
        require "views/acteur/modifierActeur.php";
    }

}