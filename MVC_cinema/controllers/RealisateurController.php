<?php
require_once "app/DAO.php";
class RealisateurController
{
    public function findAll()
    {
        $dao = new DAO;
        $sql = "SELECT id_realisateur, CONCAT(nom ,' ', prenom) as realisateur,image_realisateur
                FROM realisateur 
                ORDER BY nom";
        $realisateurs = $dao->executerRequete($sql);
        require "views/realisateur/listsRealisateur.php";
    }
            
    public function findByOneID($id)
    {
        $dao = new DAO;


        $sql = "SELECT CONCAT(nom,' ',prenom) AS realisateur , sexe ,biographie ,DATE_FORMAT(date_naissance, '%d %M %Y') AS date_naissance, image_realisateur , origine, id_realisateur
                FROM realisateur 
                WHERE id_realisateur = :id";
           
           $sql2 ="SELECT f.titre_film as titre_film , f.realisateur_id AS realisateur_id , f.id_film
                FROM film f
                WHERE realisateur_id =:id";         
        $stmtRealisateurs = $dao->executerRequete($sql,['id' => $id]);
        $stmtRealisateurs2 = $dao->executerRequete($sql2,['id' => $id]);
        require "views/realisateur/detailRealisateur.php";
    }

    public function addRealisateur()
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
                $sqlCheckIsRealisateurExist =("SELECT r.nom, r.prenom FROM realisateur r WHERE r.nom = :nom  AND r.prenom = :prenom");
                $sqlCheck = $dao->executerRequete($sqlCheckIsRealisateurExist,[ "nom" => $nom, "prenom" => $prenom ]);

                if(isset($_FILES['image_realisateur']))
                {
                    // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                    $tmpName = $_FILES['image_realisateur']['tmp_name'];
                    $name = $_FILES['image_realisateur']['name'];
                    $size = $_FILES['image_realisateur']['size'];
                    $error = $_FILES['image_realisateur']['error'];

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
                        $imagerealisateur = $file;
                    }
                    else{
                        echo "<p class='bg-danger'>Mauvaise extension</p>";
                        ;
                    };
                    // si la requete ne trouve pas une ligne en base de donnée donc == 0 on execute la requête d'insert into 
                    if($sqlCheck->rowCount()==0)
                    {
                        $dao = new DAO();
                         
                        $sql ="INSERT INTO realisateur ( nom, prenom, image_realisateur , date_naissance, sexe, biographie, origine ) 
                                VALUE ( :nom, :prenom,:image_realisateur , :date_naissance, :sexe, :biographie, :origine)" ;
                        $request = $dao->executerRequete($sql,["nom" => $nom ,"prenom" => $prenom  , "image_realisateur" => $imagerealisateur, "date_naissance" => $dateNaissance , "sexe" => $sexe, "biographie" => $biographie, "origine" => $origine]);
                        $resultat = $request->fetch();

                        header("location:index.php?action=listsRealisateurs");
                    }else{
                        echo "<p class='bg-danger'>Le réalisateur existe déjà</p>";
                    }
                }
            }else{
                echo "<p class='bg-danger'>Il manque des information pour enregister le film veuillez remplir tout les champs</p>";
            }
        }
        require "views/realisateur/ajouterRealisateur.php";
    }


    public function deletRealisateur($id){

            $dao = new DAO;
            $sql="DELETE FROM film WHERE realisateur_id = :id_realisateur";
            $sql2 = "DELETE FROM realisateur WHERE id_realisateur = :id_realisateur ";
            $delet1=  $dao->executerRequete($sql,['id_realisateur' => $id]);
            $delet2=  $dao->executerRequete($sql2,['id_realisateur' => $id]);
            header("location:index.php?action=listsRealisateurs");                   
    }

    public function modifierRealisateur($id){

        $dao = new DAO();
        $sql ="SELECT * , DATE_FORMAT(date_naissance, '%Y-%m-%d') AS date_naissance FROM realisateur WHERE id_realisateur = :id_realisateur ";
        $realisateur = $dao->executerRequete($sql, ['id_realisateur' => $id] );

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
                if(isset($_FILES['image_realisateur']))
                {
                    // si on echo $_FILES on obtient un tableau qui contient les infos dans le deuxieme [' '] on les places dans des variables
                    $tmpName = $_FILES['image_realisateur']['tmp_name'];
                    $name = $_FILES['image_realisateur']['name'];
                    $size = $_FILES['image_realisateur']['size'];
                    $error = $_FILES['image_realisateur']['error'];

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
                        $imageRealisateur = $file;
                    }
                    else{
                        echo "Mauvaise extension";
                    };

                   
                        $dao = new DAO();
                      
                        $sqlUpdate ="UPDATE realisateur SET nom = :nom , prenom = :prenom ,date_naissance = :date_naissance , sexe = :sexe ,
                         biographie = :biographie , origine = :origine, image_realisateur = :image_realisateur
                         WHERE id_realisateur = :id_realisateur ";

                        $request = $dao->executerRequete($sqlUpdate,["nom" => $nom,"prenom" => $prenom,"date_naissance" => $dateNaissance,
                                "sexe" => $sexe, "biographie" => $biographie, "origine" => $origine, "image_realisateur" => $imageRealisateur,
                                "id_realisateur" => $id ]);
                        $resultat = $request->fetch();
                        // var_dump($resultat);die;
                     
                        header("location:index.php?action=listsRealisateurs");
                }
            }else{
                echo "<p class='bg-danger'>Il manque des information pour enregister le film veuillez remplir tout les champs</p>";
            }
        }
        require "views/realisateur/modifierRealisateur.php";
    }
          
}
