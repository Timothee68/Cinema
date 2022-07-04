<?php
// c'est le controleur frontal qui va appeller la page views acceuil 
class AcceuilController
{

// Lorsqu'un fichier est require, le code le composant hérite de la portée des variables de la ligne où l'inclusion apparaît. 
    public function pageAcceuil(){
        require "./views/acceuil/acceuil.php";
    }
}


