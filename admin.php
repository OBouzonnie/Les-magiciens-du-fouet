<!-- Page d'acceuil de la section d'administration -->

<?php
session_start();
require_once('config.php');
require_once('classes/bdd.class.php');
require_once('classes/liste.class.php');
require_once('classes/recette.class.php');
require_once('classes/cuisinier.class.php');
require_once('classes/login.class.php');


// le contenu est affiché uniquement si les superglobales de session log & id existent
if(isset($_SESSION["id"]) AND isset($_SESSION["log"])){
    
    $bdd = new Bdd(DRIVER,HOST,PORT,DB,CHARSET,LOG,PWD);
    
    $cnx = $bdd->cnx();
    
    $cuisiniers = new Cuisinier($cnx);
    $liste = new ListeRecette($cnx);
    $recette = new Recette($cnx);
    $log = new Login($cnx);

    $admin = $log->getAdminByID($_SESSION["id"]);

    if($_SESSION["log"] == $admin->login){

        $cooks = $cuisiniers->getListeCuisiniers();
        $datas = $liste->getAdminListe();
        
        if(isset($_POST["deconnexion"])){
            
            $log->deconnexion();
            header('Location: index.php');
        }
        
        require('templates/admin.temp.php');
    }    
}


?>

