<?php 
// on crée un classe objet DAO contenant une propirété $bdd qui serviras a appeler la base de données 
class DAO
{
    private $bdd;
// dans le construct on donne a $bdd la valeur d'un nouvelle objet PDO pour appeller la base de donnée 
    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8','root','');
      
    }

    /**
     * Get the value of bdd
     */
    public function getBdd()
    {
        return $this->bdd;
    }
    //  fonction qui prend un ou deux paramêtre pour executer une requete sql
    public function executerRequete($sql, $params = NULL)
    {
        // si $params strictement = a NULL alors $result = la bdd en cour fonction query ->Prépare et exécute une instruction SQL sans espaces réservés
        if ($params == NULL){
            $result = $this->bdd->query($sql);
        //sinon Prépare une instruction pour exécution et renvoie un objet instruction avec ->prepare(sql) puis  Exécute une instruction préparée avec ->execute()
        }else{
            $result = $this->bdd->prepare($sql);
            $result->execute($params);
        }
        
        return $result;
    }
}